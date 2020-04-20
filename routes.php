<?php

use Illuminate\Routing\Router;

Route::group([
    // 红包页面URL前缀
    'prefix' => 'red-packet',

    // 控制器命名空间
    'namespace' => 'Qihucms\RedPacket\Controllers',

    // 红包操作仅针对已登录用户，所以添加auth，无需登录访问页使用web即可
    'middleware' => ['web', 'auth']

], function (Router $router) {
    // 发送的红包
    $router->get('/get', 'ViewController@getRedPacket')->name('plugin-red-packet.get');
    $router->get('/my-get', 'ApiController@getLog')->name('plugin-red-packet.my-get');

    // 收到的红包
    $router->get('/got', 'ViewController@gotRedPacket')->name('plugin-red-packet.got');
    $router->get('/my-got', 'ApiController@gotLog')->name('plugin-red-packet.my-got');

    // 红包的领取记录
    $router->get('/show/{id}', 'ViewController@show')->name('plugin-red-packet.show');
    $router->get('/my-show/{id}', 'ApiController@show')->name('plugin-red-packet.my-show');

    // 领取红包
    $router->post('/get', 'ApiController@getRedPacket');

    // 创建红包
    $router->post('/store', 'ApiController@gotRedPacket')->name('plugin-red-packet.store');

});

Route::group([
    // 后台使用laravel-admin的前缀加上扩展的URL前缀
    'prefix' => config('admin.route.prefix') . '/plugins',

    // 后台管理的命名空间
    'namespace' => 'Qihucms\RedPacket\Controllers\Admin',

    // 后台的中间件，限制管理权限才能访问
    'middleware' => config('admin.route.middleware'),

], function (Router $router) {
    // 红包设置
    $router->get('red-packet-config', 'SettingController@setting')->name('admin.red-packet-config');

    // 红包管理
    $router->resource('red-packet-index', 'IndexController', ['as' => 'admin']);

    // 红包日志
    $router->resource('red-packet-log', 'LogController', ['as' => 'admin']);
});