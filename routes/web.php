<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'namespace' => 'Web',
    'middleware' => [],
    'limit' => 100,
], function () {
    Route::get('/', 'IndexController@premium')->name('premium');
    Route::get('/stable', 'IndexController@stable')->name('stable');
    Route::get('/common', 'IndexController@common')->name('common');
});
