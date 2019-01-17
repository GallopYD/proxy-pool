<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Proxy;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * 代理列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $proxies = Proxy::getList($request);
        return view('index', compact('proxies'));
    }
}
