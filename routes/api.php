<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'namespace' => 'Api',
    'as' => 'api',
    'middleware' => [],
    'limit' => 100,
], function () {
    Route::get('proxies', 'ProxyController@stableList');//旧接口
    Route::get('proxies/one', 'ProxyController@stable');//旧接口

    Route::get('proxies/stable', 'ProxyController@stable');//获取稳定代理
    Route::get('proxies/premium', 'ProxyController@premium');//获取优质代理
    Route::get('proxies/list/stable', 'ProxyController@stableList');//获取稳定代理列表
    Route::get('proxies/list/premium', 'ProxyController@premiumList');//获取优质代理列表
    Route::get('proxies/check', 'ProxyController@check');
});
