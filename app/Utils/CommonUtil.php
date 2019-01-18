<?php

namespace App\Utils;

use Carbon\Carbon;

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
        $speed = printf("%.2f", ($speed / 1000)) . '秒';
        return $speed;
    }

    /**
     * 存活时间计算
     * @param $created_at
     * @return string
     */
    public static function survivalTime($created_at)
    {
        $now = Carbon::now();
        if ($days = $now->diffInDays($created_at)) {
            $time = $days . '天';
        } elseif ($hours = $now->diffInHours($created_at)) {
            $time = $hours . '小时';
        } elseif ($minutes = $now->diffInMinutes($created_at)) {
            $time = $minutes . '分钟';
        } else {
            $time = $created_at;
        }
        return $time;
    }

}