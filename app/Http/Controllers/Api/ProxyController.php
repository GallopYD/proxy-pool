<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Proxy;
use App\Http\Resources\Proxy as ProxyResource;
use App\Utils\CommonUtil;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    /**
     * 获取代理列表
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $condition = request()->all();
        $proxies = Proxy::getList($condition);
        return ProxyResource::collection($proxies);
    }

    /**
     * 获取单条代理
     * @return ProxyResource
     * @throws \Exception
     */
    public function one()
    {
        $anonymity = request('anonymity', null);
        $proxy = CommonUtil::getValidProxy($anonymity);
        if (!$proxy) {
            throw new ApiException('获取代理失败');
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
                'proxy' => [
                    $protocol => "$protocol://$ip:$port"
                ],
                'timeout' => config('proxy.time_out')
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
