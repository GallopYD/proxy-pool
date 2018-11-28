<?php

use \QL\QueryList;
use \Illuminate\Support\Facades\Log;
use \Symfony\Component\Debug\Exception\ClassNotFoundException;

class Spider
{
    static private $instance;

    private $ql;
    private $driver;
    private $time_out = 3;

    private function __construct()
    {
        $this->ql = QueryList::getInstance();
    }

    private function __clone()
    {
    }

    static public function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setDriver($driver)
    {
        $this->driver = ucfirst(substr($driver, 0, strpos($driver, '.')));
        $className = "\\App\\Spiders\\Drivers\\" . $this->driver;
        if (class_exists($className)) {
            $this->driver = new $className($this);
        } else {
            throw new ClassNotFoundException('驱动未找到:', $className);
        }
    }

    public function getDriver()
    {
        return $this->driver;
    }

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
            $ql = $this->ql->get($url, [], $options);
            //选中数据列表Table
            $table = $ql->find($table_selector);
            //遍历数据列
            $table->map(function ($tr) use ($map_func) {
                try {
                    //获取IP、端口、透明度、协议
                    list($ip, $port, $anonymity, $protocol) = call_user_func_array($map_func, [$tr]);
                    //日志记录
                    Log::info("抓取代理：{$ip}:{$port}");
                    //代理IP入库 TODO
                } catch (\Exception $e) {
                    Log::error("代理抓取失败：" . $e->getMessage());
                }
            });
        }
    }
}