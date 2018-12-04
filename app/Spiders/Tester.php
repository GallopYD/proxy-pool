<?php

namespace App\Spiders;

use App\Models\Proxy;
use App\Utils\CommonUtil;
use Carbon\Carbon;
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
     * @param Proxy $proxy
     * @throws \Exception
     */
    public function handle(Proxy $proxy)
    {
        self::check($proxy);
    }

    /**
     * Check Proxy
     * @param Proxy $proxy
     * @return bool
     * @throws \Exception
     */
    public static function check(Proxy $proxy)
    {
        try {
            $client = new Client();
            $check_url = config('proxy.check_url');
            $check_keyword = config('proxy.check_keyword');
            $begin_seconds = CommonUtil::mSecondTime();
            $proxy_url = $proxy->protocol . '://' . $proxy->ip . ':' . $proxy->port;
            $response = $client->request('GET', $check_url, [
                'proxy' => $proxy_url,
                'connect_timeout' => 2,
                'timeout' => 2,
            ]);
            if (strpos($response->getBody()->getContents(), $check_keyword) !== false) {
                $end_seconds = CommonUtil::mSecondTime();
                $speed = intval($end_seconds - $begin_seconds);
                //代理更新
                $proxy->update([
                    'speed' => $speed,
                    'checked_times' => ++$proxy->checked_times,
                    'last_checked_at' => Carbon::now(),
                ]);
                Log::info("代理检测成功[{$proxy_url}]：$speed ms[{$response->getStatusCode()}]");
                return true;
            } else {
                throw new \Exception('检测结果不包含关键字');
            }
        } catch (\Exception $exception) {
            //代理删除
            $proxy->delete();
            Log::error("代理测试失败[{$proxy_url}]：" . $exception->getMessage());
            return false;
        }
    }
}