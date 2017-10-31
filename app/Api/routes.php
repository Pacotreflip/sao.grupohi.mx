<?php

/*
* API Routes
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\Auth\AuthController@postLogin');

    $api->group(['middleware' => 'jwt.auth'], function($api) {
        $api->get('test', 'Ghi\Api\Controllers\TestController@test');
    });
});

