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
    private $time_out;

    public $sleep;
    public $inputEncoding;
    public $outputEncoding;

    private function __construct()
    {
        $this->ql = QueryList::getInstance();
        $this->time_out = config('proxy.time_out');
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
     * Process
     * @param $urls
     * @param $table_selector
     * @param $map_func
     */
    protected function process($urls, $table_selector, $map_func)
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
                        'User-Agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.3 Safari/537.36",
                        'Accept' => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                        'Upgrade-Insecure-Requests' => "1",
                        'Host' => $host,
                        'DNT' => "1",
                    ],
                    'timeout' => $this->time_out
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
                Log::error("代理爬取失败[driver:{$this->driver}][url:{$url}]：" . $e->getMessage());
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
        if ($ip & $port & $anonymity & $protocol && filter_var($ip, FILTER_VALIDATE_IP)) {
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
            static::$current_count = Proxy::count();
        }
        if (static::$current_count > config('proxy.limit_count')) {
            Log::info('代理池IP数量达到上限');
            return false;
        }
        return true;
    }
}