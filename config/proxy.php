<?php

return [

    'drivers' => env('PROXY_DRIVERS','Data5u|Ip3366|Kuaidaili|Xicidaili'),

    'time_out' => env('PROXY_TIME_OUT',3),

    'check_url' => env('PROXY_CHECK_URL','http://www.baidu.com/'),

    'limit_count' => env('PROXY_LIMIT_COUNT',2000),

    'test_count' => env('PROXY_TEST_COUNT',50),

];
