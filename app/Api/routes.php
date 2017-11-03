<?php

/*
* API Routes
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\Auth\AuthController@postLogin');

    $api->group(['middleware' => 'jwt.auth'], function($api) {
        $api->post('empresa', 'Ghi\Api\Controllers\EmpresaController@store');
        $api->get('empresa/{id_empresa}', 'Ghi\Api\Controllers\EmpresaController@show');
    });
});

