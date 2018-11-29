<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Proxy;
use App\Http\Resources\Proxy as ProxyResource;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    /**
     * 获取最新代理
     * @return ProxyResource
     */
    public function one()
    {
        $proxy = Proxy::getNewest();
        if (!$proxy) {
            throw new ApiException('获取代理失败');
        }
        return $proxy;
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
            return response($msg)->setStatusCode($exception->getCode());
        }

    }
}
