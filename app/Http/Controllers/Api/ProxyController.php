<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Proxy;
use App\Http\Resources\Proxy as ProxyResource;

class ProxyController extends Controller
{

    /**
     * 获取最新代理
     * @return ProxyResource
     */
    public function one()
    {
        $proxy = Proxy::getNewest();
        if (!$proxy) {
            throw new ApiException('获取代理失败');
        }
        return $proxy;
    }
}
