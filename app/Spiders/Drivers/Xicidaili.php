<?php

namespace App\Spiders\Drivers;

use App\Spiders\Spider;

class Xicidaili extends Spider
{
    public function handle()
    {
        $this->sleep = rand(3,5);
        $urls = [
            "http://www.xicidaili.com/nn/",
            "http://www.xicidaili.com/nn/2",
            "http://www.xicidaili.com/nn/3",
            "http://www.xicidaili.com/nt/",
            "http://www.xicidaili.com/nt/2",
            "http://www.xicidaili.com/nt/3",
            "http://www.xicidaili.com/wn/",
            "http://www.xicidaili.com/wn/2",
            "http://www.xicidaili.com/wn/3",
            "http://www.xicidaili.com/nt/",
            "http://www.xicidaili.com/nt/2",
            "http://www.xicidaili.com/nt/3",
        ];

        $this->process($urls, "table#ip_list tr", function ($tr) {
            $ip = $tr->find('td:eq(1)')->text();
            $port = $tr->find('td:eq(2)')->text();
            $anonymity = $tr->find('td:eq(4)')->text() == "高匿" ? 'anonymous' : 'transparent';
            $protocol = strtolower($tr->find('td:eq(5)')->text());
            return [$ip, $port, $anonymity, $protocol];
        });
    }
}