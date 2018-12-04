<?php

return [

    'check_url' => env('PROXY_CHECK_URL', 'http://www.baidu.com/'),
    'check_keyword' => env('PROXY_CHECK_KEYWORD', '百度一下'),

    'limit_count' => env('PROXY_LIMIT_COUNT', 100000),

    'timeout' => env('PROXY_TIME_OUT', 2),
    'connect_timeout' => env('PROXY_CONNECT_TIMEOUT', 2),

];
