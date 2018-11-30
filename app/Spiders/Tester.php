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
     */
    public function handle(Proxy $proxy)
    {
        if ($speed = self::check($proxy->ip, $proxy->port, $proxy->protocol)) {
            $proxy->speed = $speed;
            $proxy->checked_at = Carbon::now();
            $proxy->update();
        } else {
            $proxy->delete();
        }
    }

    /**
     * Check Proxy
     * @param $ip
     * @param $port
     * @param $protocol
     * @return bool|int
     */
    public static function check($ip, $port, $protocol)
    {
        try {
            $client = new Client();
            $check_url = config('proxy.check_url');
            $begin_seconds = CommonUtil::mSecondTime();
            $response = $client->request('GET', $check_url, [
                'proxy' => [
                    "$protocol://$ip:$port"
                ],
                'timeout' => 2
            ]);
            $end_seconds = CommonUtil::mSecondTime();
            $speed = intval($end_seconds - $begin_seconds);
            Log::info("代理检测成功[$protocol://$ip:$port]：$speed ms[{$response->getStatusCode()}]");
            return $speed;
        } catch (\Exception $exception) {
            Log::error("代理测试失败[$protocol://$ip:$port]：" . $exception->getMessage());
            return false;
        }
    }
}