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
         * procuración asignación
         */
        $api->post('procuracion/asignacion', 'Ghi\Api\Controllers\v1\Procuracion\AsignacionController@store');
        $api->post('procuracion/asignacion/masivas', 'Ghi\Api\Controllers\v1\Procuracion\AsignacionController@maxivas');
        $api->post('procuracion/asignacion/paginate', 'Ghi\Api\Controllers\v1\Procuracion\AsignacionController@paginate');
        $api->get('procuracion/asignacion/{id}', 'Ghi\Api\Controllers\v1\Procuracion\AsignacionController@find')->where(['id' => '[0-9]+']);
        $api->delete('procuracion/asignacion/{id}', 'Ghi\Api\Controllers\v1\Procuracion\AsignacionController@delete')->where(['id' => '[0-9]+']);

        /**
         *
         */
        $api->post('usuario', 'Ghi\Api\Controllers\v1\UsuarioController@show');
        $api->post('tipoTran', 'Ghi\Api\Controllers\v1\TipoTranController@show');
        $api->post('contratoProyectado', 'Ghi\Api\Controllers\v1\ContratoProyectadoController@show');
        $api->post('compras/requisicion', 'Ghi\Api\Controllers\v1\Compras\RequisicionController@show');


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
        $api->post('tesoreria/movimientos_bancarios/store', 'Ghi\Api\Controllers\v1\Tesoreria\MovimientosBancariosController@store');
        $api->delete('tesoreria/movimientos_bancarios/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\MovimientosBancariosController@delete')->where(['id' => '[0-9]+']);
        $api->get('tesoreria/movimientos_bancarios/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\MovimientosBancariosController@show')->where(['id' => '[0-9]+']);
        $api->put('tesoreria/movimientos_bancarios/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\MovimientosBancariosController@update')->where(['id' => '[0-9]+']);
        /**
         * Sistema Contable
         * Poliza Tipo
         */
        $api->post('sistema_contable/poliza_tipo/paginate', 'Ghi\Api\Controllers\v1\SistemaContable\PolizaTipoController@paginate');
        $api->delete('sistema_contable/poliza_tipo/{id}', 'Ghi\Api\Controllers\v1\SistemaContable\PolizaTipoController@delete')->where(['id' => '[0-9]+']);

        /*
         * Layouts Routes
         */
        $api->get('layouts/compras/requisicion/{id_requisicion}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@compras_asignacion');
        $api->post('layouts/compras/requisicion/{id_requisicion}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@compras_asignacion_store');

        $api->get('layouts/compras/carga_precios/{id_requisicion}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@carga_precios_compras_asignacion');
        $api->post('layouts/compras/carga_precios/{id_requisicion}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@carga_precios_compras_asignacion_store');

        $api->get('layouts/contratos/contrato_proyectado/{id_contrato_proyectado}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@contratos_asignacion');
        $api->post('layouts/contratos/contrato_proyectado/{id_contrato_proyectado}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@contratos_asignacion_store');

        $api->get('layouts/contratos/carga_precios/{id_contrato_proyectado}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@carga_precios_asignacion');
        $api->post('layouts/contratos/carga_precios/{id_contrato_proyectado}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@carga_precios_asignacion_store');

    });
});

$api->version('v2' , function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\v2\Auth\AuthController@postLogin');
});
