<?php

namespace App\Spiders\Drivers;

use App\Spiders\Spider;

class Data5u extends Spider
{
    public function handle()
    {
        $urls = [
            "http://www.data5u.com/free/index.shtml",
            "http://www.data5u.com/free/gngn/index.shtml",
            "http://www.data5u.com/free/gnpt/index.shtml",
            "http://www.data5u.com/free/gwgn/index.shtml",
            "http://www.data5u.com/free/gwpt/index.shtml"
        ];

        $this->process($urls, "ul.l2", function ($tr) {
            $ip = $tr->find('li:eq(0)')->text();
            $port = $tr->find('li:eq(1)')->text();
            return $ip && $port ? $ip . ':' . $port : null;
        });
    }
}