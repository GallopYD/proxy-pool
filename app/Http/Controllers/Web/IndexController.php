<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Proxy;

class IndexController extends Controller
{

    /**
     * 获取最新代理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $per_page = request('per_page', 20);
        $proxies = Proxy::getList($per_page);
        return view('index', compact('proxies'));
    }
}
