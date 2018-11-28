<?php

namespace App\Spiders\Drivers;

use App\Spiders\Spider;

class Sixsixip extends Spider
{
    public function handle()
    {
        $urls = [
            "http://www.66ip.cn/1.html",
            "http://www.66ip.cn/2.html",
            "http://www.66ip.cn/3.html",
            "http://www.66ip.cn/4.html",
            "http://www.66ip.cn/5.html",
            "http://www.66ip.cn/6.html",
        ];

        $this->process($urls, "#main table tr", function ($tr) {
            $ip = $tr->find('td:eq(0)')->text();
            $port = $tr->find('td:eq(1)')->text();
            return $ip && $port ? $ip . ':' . $port : null;
        });
    }
}