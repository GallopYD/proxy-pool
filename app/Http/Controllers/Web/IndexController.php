<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Proxy;

class IndexController extends Controller
{

    /**
     * 获取最新代理
     * @return ProxyResource
     */
    public function index()
    {
        $proxies = Proxy::getList();
        return view('index', compact('proxies'));
    }
}
