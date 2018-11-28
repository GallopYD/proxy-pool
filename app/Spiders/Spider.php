<?php

namespace App\Spiders;

use GuzzleHttp\Client;
use \QL\QueryList;
use \Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\Redis;
use \Symfony\Component\Debug\Exception\ClassNotFoundException;

class Spider
{
    static private $instance;

    private $ql;
    private $driver;
    private $time_out;
    public $sleep;

    private function __construct()
    {
        $this->ql = QueryList::getInstance();
        $this->time_out = config('proxy.time_out');
    }

    private function __clone()
    {
    }

    /**
     * get instance
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
     * set driver
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
     * get driver
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * handle
     */
    public function handle()
    {
        $this->driver->handle();
    }

    /**
     * 爬取过程
     * @param $urls
     * @param $table_selector
     * @param $map_func
     */
    protected function process($urls, $table_selector, $map_func)
    {
        foreach ($urls as $url) {
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
            //获取数据列表
            $table = $content->find($table_selector);
            //遍历数据列
            $table->map(function ($tr) use ($map_func) {
                try {
                    //代理入库
                    if ($proxy = call_user_func_array($map_func, [$tr])) {
                        $this->addProxy($proxy);
                    }
                } catch (\Exception $e) {
                    Log::error("代理爬取失败[{$this->driver}]：" . $e->getMessage());
                }
            });
            if ($this->sleep) {
                sleep($this->sleep);
            }
        }
    }

    /**
     * 代理入库
     * @param $proxy
     */
    protected function addProxy($proxy)
    {
        Redis::rpush('proxies', $proxy);
        Log::info("代理入库：$proxy");
    }

    /**
     * 代理检测
     * @param $proxy
     * @return string
     */
    public function checkProxy($proxy)
    {
        $client = new Client();
        $check_url = config('proxy.check_url');
        $response = $client->request('GET', $check_url, [
            'proxy' => [
                "http://$proxy"
            ],
            'timeout' => $this->time_out
        ]);
        return $response->getBody()->getContents();
    }
}