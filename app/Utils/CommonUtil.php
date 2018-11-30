<?php

namespace App\Utils;

use App\Models\Proxy;
use App\Spiders\Tester;

class CommonUtil
{
    /**
     * 获取当前毫秒
     * @return float
     */
    public static function mSecondTime()
    {
        list($m_seconds, $seconds) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($m_seconds) + floatval($seconds)) * 1000);
    }

    /**
     * 格式化显示响应速度
     * @param $speed
     * @return string
     */
    public static function formatSpeed($speed)
    {
        if ($speed <= 500) {
            return $speed . '毫秒';
        }
        return printf("%.2f", ($speed / 1000)) . '秒';
    }

    /**
     * 获取可用代理
     * @param $anonymity
     * @return bool|\Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getValidProxy($anonymity)
    {
        $proxy = Proxy::getNewest($anonymity);
        if ($proxy) {
            if (Tester::check($proxy->ip, $proxy->port, $proxy->protocol)) {
                return $proxy;
            } else {
                self::getValidProxy($anonymity);
            }
        }
        return false;
    }

}