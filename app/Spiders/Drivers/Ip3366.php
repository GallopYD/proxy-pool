<?php

namespace App\Spiders\Drivers;

use App\Models\Proxy;
use App\Spiders\Spider;

class Ip3366 extends Spider
{
    public function handle()
    {
        $this->sleep = rand(3, 5);
        $this->inputEncoding = 'GB2312';
        $this->outputEncoding = 'UTF-8';
        $urls = [
            "http://www.ip3366.net/free/?stype=1&page=1",
            "http://www.ip3366.net/free/?stype=1&page=2",
            "http://www.ip3366.net/free/?stype=1&page=3",
            "http://www.ip3366.net/free/?stype=1&page=4",
            "http://www.ip3366.net/free/?stype=2&page=1",
            "http://www.ip3366.net/free/?stype=2&page=2",
            "http://www.ip3366.net/free/?stype=2&page=3",
            "http://www.ip3366.net/free/?stype=2&page=4",
            "http://www.ip3366.net/free/?stype=3&page=1",
            "http://www.ip3366.net/free/?stype=3&page=2",
            "http://www.ip3366.net/free/?stype=3&page=3",
            "http://www.ip3366.net/free/?stype=3&page=4",
            "http://www.ip3366.net/free/?stype=4&page=1",
            "http://www.ip3366.net/free/?stype=4&page=2",
            "http://www.ip3366.net/free/?stype=4&page=3",
            "http://www.ip3366.net/free/?stype=4&page=4",
        ];

        $this->queryListProcess($urls, "#list table tbody tr", function ($tr) {
            $ip = $tr->find('td:eq(0)')->text();
            $port = $tr->find('td:eq(1)')->text();
            $temp = $tr->find('td:eq(2)')->text();
            if (strpos($temp, '高匿') !== false) {
                $anonymity = Proxy::ANONYMITY_HIGH_ANONYMOUS;
            } elseif (strpos($temp, '透明') !== false) {
                $anonymity = Proxy::ANONYMITY_TRANSPARENT;
            } else {
                $anonymity = Proxy::ANONYMITY_ANONYMOUS;
            }
            $protocol = strtolower($tr->find('td:eq(3)')->text());
            return [$ip, $port, $anonymity, $protocol];
        });
    }
}