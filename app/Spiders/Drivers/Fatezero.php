<?php

namespace App\Spiders\Drivers;

use App\Spiders\Spider;

class Fatezero extends Spider
{
    public function handle()
    {
        $this->sleep = rand(3,5);
        $this->timeout = 60;
        $this->connect_timeout = 60;
        $urls = [
            "http://proxylist.fatezero.org/proxy.list",
        ];

        $this->regexProcess($urls, "/\{(.*?)\}/is", function ($row) {
            $data = json_decode($row,true);
            $ip = $data['host'];
            $port = $data['port'];
            $anonymity = $data['anonymity'];
            $protocol = $data['type'];
            return [$ip, $port, $anonymity, $protocol];
        });
    }
}