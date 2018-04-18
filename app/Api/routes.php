<?php

/*
* API Routes
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth', 'Ghi\Api\Controllers\v1\Auth\AuthController@postLogin');

    $api->group(['middleware' => ['jwt.auth', 'api.context']], function($api) {

        $api->post('empresa', 'Ghi\Api\Controllers\v1\EmpresaController@store');
        $api->post('sucursal', 'Ghi\Api\Controllers\v1\SucursalController@store');

        $api->post('contrato_proyectado', 'Ghi\Api\Controllers\v1\ContratoProyectadoController@store');
        $api->post('contrato_proyectado/{id_contrato_proyectado}/addContratos', 'Ghi\Api\Controllers\v1\ContratoProyectadoController@addContratos');

        $api->patch('contrato/{id}', 'Ghi\Api\Controllers\v1\ContratoController@update');

        $api->post('subcontrato', 'Ghi\Api\Controllers\v1\SubcontratoController@store');

        $api->post('item', 'Ghi\Api\Controllers\v1\ItemController@store');
        $api->patch('item/{id_item}', 'Ghi\Api\Controllers\v1\ItemController@update');

        $api->post('estimacion', 'Ghi\Api\Controllers\v1\EstimacionController@store');

        $api->post('conciliacion', 'Ghi\Api\Controllers\v1\ConciliacionController@store');

        $api->get('conciliacion/costos', 'Ghi\Api\Controllers\v1\ConciliacionController@getCostos');

        $api->delete('conciliacion/{id}', 'Ghi\Api\Controllers\v1\ConciliacionController@delete');

        /*
         * Formatos Routes
         */
        $api->get('formatos/compras/requisicion/{id_requisicion}/comparativa_cotizaciones_compra', 'Ghi\Api\Controllers\v1\FormatosController@comparativa_cotizaciones_compra')
            ->where(['id' => '[0-9]+']);

        $api->get('formatos/contratos/contrato_proyectado/{id_contrato_proyectado}/comparativa_cotizaciones_contrato', 'Ghi\Api\Controllers\v1\FormatosController@comparativa_cotizaciones_contrato')
            ->where(['id' => '[0-9]+']);
        /**
         * traspaso cuentas
         */
        $api->post('tesoreria/traspaso_cuentas', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@paginate');
        $api->post('tesoreria/traspaso_cuentas/store', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@store');
        $api->delete('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@delete')->where(['id' => '[0-9]+']);
        $api->get('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@show')->where(['id' => '[0-9]+']);
        $api->put('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@update')->where(['id' => '[0-9]+']);
        /**
         * movimientos bancarios
         */
        $api->post('tesoreria/movimientos_bancarios', 'Ghi\Api\Controllers\v1\Tesoreria\MovimientosBancariosController@paginate');
    });
});

$api->version('v2' , function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\v2\Auth\AuthController@postLogin');
});
