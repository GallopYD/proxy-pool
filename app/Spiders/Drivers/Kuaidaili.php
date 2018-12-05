<?php

namespace App\Spiders\Drivers;

use App\Models\Proxy;
use App\Spiders\Spider;

class Kuaidaili extends Spider
{
    public function handle()
    {
        $this->sleep = rand(3, 5);
        $urls = [
            "http://www.kuaidaili.com/free/inha/",
            "http://www.kuaidaili.com/free/inha/2/",
            "http://www.kuaidaili.com/free/inha/3/",
            "http://www.kuaidaili.com/free/inha/4/",
            "http://www.kuaidaili.com/free/inha/5/",
            "http://www.kuaidaili.com/free/intr/",
            "http://www.kuaidaili.com/free/intr/2/",
            "http://www.kuaidaili.com/free/intr/3/",
            "http://www.kuaidaili.com/free/intr/4/",
            "http://www.kuaidaili.com/free/intr/5/",
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