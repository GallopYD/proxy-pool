<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Proxy as ProxyResource;
use App\Models\PremiumProxy;
use App\Models\StableProxy;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    /**
     * 获取稳定代理列表
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function stableList()
    {
        $condition = request()->all();
        $proxies = StableProxy::getList($condition);
        return ProxyResource::collection($proxies);
    }

    /**
     * 获取优质代理列表
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function premiumList()
    {
        $condition = request()->all();
        $proxies = PremiumProxy::getList($condition);
        return ProxyResource::collection($proxies);
    }

    /**
     * 获取稳定代理
     * @return ProxyResource
     * @throws \Exception
     */
    public function stable()
    {
        $anonymity = request('anonymity', null);
        $proxy = StableProxy::getNewest($anonymity);
        if (!$proxy) {
            return response()->json([]);
        }
        return new ProxyResource($proxy);
    }

    /**
     * 获取优质代理
     * @return ProxyResource
     * @throws \Exception
     */
    public function premium()
    {
        $anonymity = request('anonymity', null);
        $proxy = PremiumProxy::getNewest($anonymity);
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
