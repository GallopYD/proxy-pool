<?php

namespace App\Spiders;

use App\Utils\CommonUtil;
use GuzzleHttp\Client;
use \Illuminate\Support\Facades\Log;

class Tester
{
    static private $instance;

    private $time_out;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Get Instance
     * @return Tester
     */
    static public function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Handle
     * @param $proxy
     * @return bool
     */
    public function handle($proxy)
    {
        return self::check($proxy);
    }

    /**
     * Check Proxy
     * @param $proxy
     * @return bool|int
     */
    public static function check($proxy)
    {
        try {
            $client = new Client();
            $check_url = config('proxy.check_url');
            $check_keyword = config('proxy.check_keyword');
            $begin_seconds = CommonUtil::mSecondTime();
            $response = $client->request('GET', $check_url, [
                'proxy' => $proxy,
                'verify' => false,
                'connect_timeout' => config('proxy.connect_timeout'),
                'timeout' => config('proxy.timeout')
            ]);
            if (strpos($response->getBody()->getContents(), $check_keyword) !== false) {
                $end_seconds = CommonUtil::mSecondTime();
                $speed = intval($end_seconds - $begin_seconds);
                Log::info("代理检测成功[{$proxy}]：$speed ms[{$response->getStatusCode()}]");
                return $speed;
            } else {
                throw new \Exception('检测结果不包含关键字');
            }
        } catch (\Exception $exception) {
            Log::error("代理测试失败[{$proxy}]：" . $exception->getMessage());
            return false;
        }
    }
}