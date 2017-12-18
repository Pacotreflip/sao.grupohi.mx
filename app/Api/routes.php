<?php

/*
* API Routes
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Origin, Content-Type, X-Auth-Token, database_name, id_obra');

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth', 'Ghi\Api\Controllers\Auth\AuthController@postLogin');

    $api->group(['middleware' => ['jwt.auth', 'api.context']], function($api) {

        $api->post('empresa', 'Ghi\Api\Controllers\EmpresaController@store');
        $api->post('sucursal', 'Ghi\Api\Controllers\SucursalController@store');

        $api->post('contrato_proyectado', 'Ghi\Api\Controllers\ContratoProyectadoController@store');
        $api->post('contrato_proyectado/{id_contrato_proyectado}/addContratos', 'Ghi\Api\Controllers\ContratoProyectadoController@addContratos');

        $api->patch('contrato/{id}', 'Ghi\Api\Controllers\ContratoController@update');

        $api->post('subcontrato', 'Ghi\Api\Controllers\SubcontratoController@store');

        $api->post('item', 'Ghi\Api\Controllers\ItemController@store');
        $api->patch('item/{id_item}', 'Ghi\Api\Controllers\ItemController@update');

        $api->post('estimacion', 'Ghi\Api\Controllers\EstimacionController@store');

        $api->post('conciliacion', 'Ghi\Api\Controllers\ConciliacionController@store');

        $api->get('conciliacion/costos', 'Ghi\Api\Controllers\ConciliacionController@getCostos');

    });
});