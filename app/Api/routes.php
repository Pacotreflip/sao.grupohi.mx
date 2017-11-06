<?php

/*
* API Routes
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\Auth\AuthController@postLogin');

    $api->group(['middleware' => ['jwt.auth', 'api.context']], function($api) {
        $api->post('empresa', 'Ghi\Api\Controllers\EmpresaController@store');
        $api->post('sucursal', 'Ghi\Api\Controllers\SucursalController@store');

        $api->post('contrato_proyectado', 'Ghi\Api\Controllers\ContratoProyectadoController@store');
        $api->patch('contrato_proyectado/{id}', 'Ghi\Api\Controllers\ContratoProyectadoController@update');
    });
});