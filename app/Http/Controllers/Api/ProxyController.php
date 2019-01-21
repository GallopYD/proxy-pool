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
     * 获取单条代理
     * @SWG\Get(
     *     path="/api/proxies/{quality}",
     *     tags={"Proxy"},
     *     @SWG\Parameter(name="quality",required=true,in="path",type="string",default="premium",enum={"common", "stable", "premium"},description="质量"),
     *     @SWG\Parameter(name="protocol",required=false,in="query",type="string",enum={"http", "https"},description="协议"),
     *     @SWG\Parameter(name="anonymity",required=false,in="query",type="string",enum={"transparent", "anonymous","high_anonymous"},description="隐匿度"),
     *     @SWG\Response(response="200", description="")
     * )
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
     * 获取代理列表
     * @SWG\Get(
     *     path="/api/proxies/{quality}/list",
     *     tags={"Proxy"},
     *     @SWG\Parameter(name="quality",required=true,in="path",type="string",default="premium",enum={"common", "stable", "premium"},description="质量"),
     *     @SWG\Parameter(name="protocol",required=false,in="query",type="string",enum={"http", "https"},description="协议"),
     *     @SWG\Parameter(name="anonymity",required=false,in="query",type="string",enum={"transparent", "anonymous","high_anonymous"},description="隐匿度"),
     *     @SWG\Response(response="200", description="")
     * )
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $proxies = Proxy::getList($request);
        return ProxyResource::collection($proxies);
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
