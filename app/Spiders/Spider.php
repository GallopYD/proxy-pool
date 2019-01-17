<?php

namespace App\Spiders;

use App\Models\Proxy;
use GuzzleHttp\Client;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use \QL\QueryList;
use \Illuminate\Support\Facades\Log;

class Spider
{
    static private $instance;
    static public $current_count;

    private $ql;
    private $driver;

    public $timeout;
    public $connect_timeout;
    public $sleep;
    public $use_proxy = false;
    public $inputEncoding;
    public $outputEncoding;

    private function __construct()
    {
        $this->ql = QueryList::getInstance();
        $this->timeout = config('proxy.timeout');
        $this->connect_timeout = config('proxy.connect_timeout');
    }

    private function __clone()
    {
    }

    /**
     * Get Instance
     * @return Spider
     */
    static public function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Set Driver
     * @param $driver
     * @throws ClassNotFoundException
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
        $className = "\\App\\Spiders\\Drivers\\" . $this->driver;
        if (class_exists($className)) {
            $this->driver = new $className($this);
        } else {
            throw new ClassNotFoundException('驱动未找到:', $className);
        }
    }

    /**
     * Get Driver
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Handle
     */
    public function handle()
    {
        $this->driver->handle();
    }

    /**
     * QueryList Process
     * @param $urls
     * @param $table_selector
     * @param $map_func
     */
    protected function queryListProcess($urls, $table_selector, $map_func)
    {
        foreach ($urls as $url) {
            //代理池上限判断
            if (!$this->checkLimit()) {
                break;
            }
            try {
                $host = parse_url($url, PHP_URL_HOST);
                $options = [
                    'headers' => [
                        'Referer' => "http://$host/",
                        'User-Agent' => $this->getUserAgent(),
                        'Accept' => "text/html,application/xhtml+xml,application/xml;",
                        'Upgrade-Insecure-Requests' => "1",
                        'Host' => $host,
                        'DNT' => "1",
                    ],
                    'connect_timeout' => $this->connect_timeout,
                    'timeout' => $this->timeout
                ];
                //抓取网页内容
                $content = $this->ql->get($url, [], $options);
                //编码设置
                if ($this->inputEncoding && $this->outputEncoding) {
                    $content->encoding($this->outputEncoding, $this->inputEncoding);
                }
                //获取数据列表
                $table = $content->find($table_selector);
                //遍历数据列
                $table->map(function ($tr) use ($map_func) {
                    //获取IP、端口、透明度、协议
                    list($ip, $port, $anonymity, $protocol) = call_user_func_array($map_func, [$tr]);
                    //代理入库
                    $this->addProxy($ip, $port, $anonymity, $protocol);
                });
            } catch (\Exception $e) {
                Log::error("代理爬取失败[url:{$url}]：" . $e->getMessage());
            }
            if ($this->sleep) {
                sleep($this->sleep);
            }
        }
    }

    /**
     *  Regex Process
     * @param $urls
     * @param $pattern
     * @param $map_func
     */
    protected function regexProcess($urls, $pattern, $map_func)
    {
        ini_set('memory_limit', '1024M');
        foreach ($urls as $url) {
            //代理池上限判断
            if (!$this->checkLimit()) {
                break;
            }
            try {
                $client = new Client();
                $response = $client->request('GET', $url, [
                    'connect_timeout' => $this->connect_timeout,
                    'timeout' => $this->timeout
                ]);
                $data = $response->getBody()->getContents();
                preg_match_all($pattern, $data, $matches);
                foreach ($matches[0] as $row) {
                    //获取IP、端口、透明度、协议
                    list($ip, $port, $anonymity, $protocol) = call_user_func_array($map_func, [$row]);
                    //代理入库
                    $this->addProxy($ip, $port, $anonymity, $protocol);
                }
            } catch (\Exception $e) {
                Log::error("代理爬取失败[url:{$url}]：" . $e->getMessage());
            }
            if ($this->sleep) {
                sleep($this->sleep);
            }
        }
    }

    /**
     * Add Proxy
     * @param $proxy
     */
    protected function addProxy($ip, $port, $anonymity, $protocol)
    {
        $exists = Proxy::whereIp($ip)
            ->wherePort($port)
            ->whereProtocol($protocol)
            ->exists();
        if (!$exists && $this->checkData($ip, $port, $anonymity, $protocol) && $this->checkLimit()) {
            $proxy = new Proxy();
            $proxy->ip = $ip;
            $proxy->port = $port;
            $proxy->anonymity = $anonymity;
            $proxy->protocol = $protocol;
            $proxy->save();
            static::$current_count++;
            Log::info("代理入库：$proxy");
        }
    }

    /**
     * Check Data
     * @return bool
     */
    private function checkData($ip, $port, $anonymity, $protocol)
    {
        if ($ip && $port && $anonymity && $protocol && filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }
        return false;
    }

    /**
     * Check Limit
     * @return bool
     */
    private function checkLimit()
    {
        if (!static::$current_count) {
            static::$current_count = Proxy::whereQuality(Proxy::QUALITY_COMMON)->count();
        }
        if (static::$current_count > config('proxy.limit_count')) {
            Log::info('代理池IP数量达到上限');
            return false;
        }
        return true;
    }

    /**
     * Get User-Agent
     * @return mixed
     */
    private function getUserAgent()
    {
        $user_agents = [
            'Mozilla/5.0 (Linux; Android 4.1.1; Nexus 7 Build/JRO03D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19',
            'Mozilla/5.0 (Linux; U; Android 4.0.4; en-gb; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            'Mozilla/5.0 (Linux; U; Android 2.2; en-gb; GT-P1000 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
            'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0',
            'Mozilla/5.0 (Android; Mobile; rv:14.0) Gecko/14.0 Firefox/14.0',
            'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.94 Safari/537.36',
            'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19',
            'Mozilla/5.0 (iPad; CPU OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3',
            'Mozilla/5.0 (iPod; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3A101a Safari/419.3'
        ];
        return $user_agents[rand(0, count($user_agents) - 1)];
    }
}