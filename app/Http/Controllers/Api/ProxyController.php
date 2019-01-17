<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Proxy as ProxyResource;
use App\Models\Proxy;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    /**
     * 获取代理列表
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $proxies = Proxy::getList($request);
        return ProxyResource::collection($proxies);
    }

    /**
     * 获取单个代理
     * @param Request $request
     * @return ProxyResource|\Illuminate\Http\JsonResponse
     */
    public function one(Request $request)
    {
        $proxy = Proxy::getNewest($request);
        if (!$proxy) {
            return response()->json([]);
        }
        return new ProxyResource($proxy);
    }

    /**
     * 代理测试
     * @param Request $request
     * @return string
     */
    public function check(Request $request)
    {
        $id = $request->id;
        $ip = $request->ip;
        $port = $request->port;
        $protocol = $request->protocol;
        $web_link = $request->web_link;
        try {
            $client = new Client();
            $response = $client->request('GET', $web_link, [
                'proxy' => "$protocol://$ip:$port",
                'verify' => false,
                'connect_timeout' => config('proxy.connect_timeout'),
                'timeout' => config('proxy.timeout')
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $exception) {
            if ($proxy = Proxy::find($id)) {
                $proxy->delete();
            }
            $msg = '测速失败：' . $exception->getMessage();
            return response($msg);
        }
    }
}
