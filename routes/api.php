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
    Route::get('proxies/{quality}', 'ProxyController@one');//获取单个代理
    Route::get('proxies/{quality}/list', 'ProxyController@index');//获取代理列表
    Route::get('proxies/check', 'ProxyController@check');
});
