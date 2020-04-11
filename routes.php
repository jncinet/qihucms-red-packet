<?php

use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'red-packet',
    'namespace' => 'Qihucms\RedPacket\Controllers',
    'middleware' => ['web', 'auth']
], function (Router $router) {
    $router->get('/get', 'ViewController@getRedPacket')->name('red-packet.get');
    $router->get('/got', 'ViewController@gotRedPacket')->name('red-packet.got');
    $router->get('/show', 'ViewController@show')->name('red-packet.show');

    $router->post('/get', 'ApiController@getRedPacket');
    $router->post('/got', 'ApiController@gotRedPacket');
    $router->post('/show', 'ApiController@getRedPacket');
});