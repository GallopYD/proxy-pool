<?php

namespace App\Spiders\Drivers;

use App\Spiders\Spider;

class Xicidaili extends Spider
{
    public function handle()
    {
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
            return $ip . ':' . $port;
        });
    }
}