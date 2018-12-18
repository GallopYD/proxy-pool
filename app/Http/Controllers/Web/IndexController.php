<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Proxy;

class IndexController extends Controller
{

    /**
     * 代理列表
     * @param string $quality
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($quality = Proxy::QUALITY_PREMIUM)
    {
        $proxies = Proxy::getList($quality);
        return view('index', compact('proxies'));
    }
}
