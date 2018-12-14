<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PremiumProxy;
use App\Models\Proxy;
use App\Models\StableProxy;

class IndexController extends Controller
{

    /**
     * 优质代理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function premium()
    {
        $per_page = request('per_page', 20);
        $proxies = PremiumProxy::getList($per_page);
        return view('index', compact('proxies'));
    }

    /**
     * 稳定代理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stable()
    {
        $per_page = request('per_page', 20);
        $proxies = StableProxy::getList($per_page);
        return view('index', compact('proxies'));
    }

    /**
     * 普通代理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function common()
    {
        $per_page = request('per_page', 20);
        $proxies = Proxy::getList($per_page);
        return view('index', compact('proxies'));
    }
}
