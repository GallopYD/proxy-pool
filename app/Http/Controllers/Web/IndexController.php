<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StableProxy;

class IndexController extends Controller
{

    /**
     * 获取稳定代理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $per_page = request('per_page', 20);
        $proxies = StableProxy::getList($per_page);
        return view('index', compact('proxies'));
    }
}
