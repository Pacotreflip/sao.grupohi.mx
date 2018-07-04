<?php

/*
* API Routes
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth', 'Ghi\Api\Controllers\v1\Auth\AuthController@postLogin');

    $api->group(['middleware' => ['jwt.auth', 'api.context']], function($api) {

        $api->get('costo/jstree', 'Ghi\Api\Controllers\v1\CostoController@getRoot');
        $api->get('costo/{id}/jstree', 'Ghi\Api\Controllers\v1\CostoController@getNode')->where(['id' => '[0-9]+']);

        $api->post('empresa', 'Ghi\Api\Controllers\v1\EmpresaController@store');
        $api->get('empresa/{id}', 'Ghi\Api\Controllers\v1\EmpresaController@find')->where(['id' => '[0-9]+']);
        $api->get('empresa/lists', 'Ghi\Api\Controllers\v1\EmpresaController@lists');
        $api->post('sucursal', 'Ghi\Api\Controllers\v1\SucursalController@store');

        $api->post('contrato_proyectado', 'Ghi\Api\Controllers\v1\ContratoProyectadoController@store');
        $api->post('contrato_proyectado/{id_contrato_proyectado}/addContratos', 'Ghi\Api\Controllers\v1\ContratoProyectadoController@addContratos');

        $api->patch('contrato/{id}', 'Ghi\Api\Controllers\v1\ContratoController@update');

        $api->post('subcontrato', 'Ghi\Api\Controllers\v1\SubcontratoController@store');
        $api->get('subcontrato/{id}', 'Ghi\Api\Controllers\v1\SubcontratoController@find');

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
         * Tesoreria Routes
         */
        $api->post('tesoreria/traspaso_cuentas', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@paginate');
        $api->post('tesoreria/traspaso_cuentas/store', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@store');
        $api->delete('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@delete')->where(['id' => '[0-9]+']);
        $api->get('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@show')->where(['id' => '[0-9]+']);
        $api->put('tesoreria/traspaso_cuentas/{id_traspaso}', 'Ghi\Api\Controllers\v1\Tesoreria\TraspasoCuentasController@update')->where(['id' => '[0-9]+']);

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

        $api->get('sistema_contable/factura_transaccion', 'Ghi\Api\Controllers\v1\SistemaContable\FacturaTransaccionController@index');

        /*
         * Layouts Routes
         */
        $api->get('layouts/compras/requisicion/{id}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@compras_asignacion')->where(['id' => '[0-9]+']);
        $api->post('layouts/compras/requisicion/{id}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@compras_asignacion_store')->where(['id' => '[0-9]+']);

        $api->get('layouts/contratos/contrato_proyectado/{id}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@contratos_asignacion')->where(['id' => '[0-9]+']);
        $api->post('layouts/contratos/contrato_proyectado/{id}/asignacion', 'Ghi\Api\Controllers\v1\LayoutsController@contratos_asignacion_store')->where(['id' => '[0-9]+']);

        /**
         * Solicitudes de Pago
         */
        $api->post('finanzas/solicitud_pago/reposicion_fondo_fijo', 'Ghi\Api\Controllers\v1\Finanzas\ReposicionFondoFijoController@store');
        $api->post('finanzas/solicitud_pago/pago_cuenta', 'Ghi\Api\Controllers\v1\Finanzas\PagoCuentaController@store');
        $api->get('finanzas/solicitud_pago/pago_cuenta/tipos_transaccion', 'Ghi\Api\Controllers\v1\Finanzas\PagoCuentaController@getTiposTran');
        $api->get('finanzas/solicitud_pago', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudPagoController@index');
        $api->post('finanzas/solicitud_pago/paginate', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudPagoController@paginate');

        /**
         * Solicitud de Recursos
         */
        $api->get('finanzas/solicitud_recursos/{id}', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@show')->where(['id' => '[0-9]+']);
        $api->post('finanzas/solicitud_recursos/paginate', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@paginate');
        $api->post('finanzas/solicitud_recursos', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@store');
        $api->get('finanzas/solicitud_recursos/solicitud_semana', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@getSolicitudSemana');
        $api->post('finanzas/solicitud_recursos/{id}/finalizar', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@finalizar')->where(['id' => '[0-9]+']);
        $api->post('finanzas/solicitud_recursos/{id}/agregar_partida', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@agregarPartida')->where(['id' => '[0-9]+']);
        $api->delete('finanzas/solicitud_recursos/{id}/remover_partida', 'Ghi\Api\Controllers\v1\Finanzas\SolicitudRecursosController@removerPartida')->where(['id' => '[0-9]+']);

        /**
         * Carga de Expediente
         */
        $api->post('finanzas/carga_expediente/{id}', 'Ghi\Api\Controllers\v1\Finanzas\CargaExpedienteController@store');

        /**
         * Fondos
         */
        $api->get('fondo', 'Ghi\Api\Controllers\v1\FondoController@index');
        $api->get('fondo/lists', 'Ghi\Api\Controllers\v1\FondoController@lists');
        $api->get('fondo/{id}', 'Ghi\Api\Controllers\v1\FondoController@find')->where(['id' => '[0-9]+']);
        $api->get('fondo/search', 'Ghi\Api\Controllers\v1\FondoController@search');

        /**
         * comprobante fondo fijo
         */
        $api->get('finanzas/comprobante_fondo_fijo/search', 'Ghi\Api\Controllers\v1\Finanzas\ComprobanteFondoFijoController@search');
        $api->get('finanzas/comprobante_fondo_fijo/{id}', 'Ghi\Api\Controllers\v1\Finanzas\ComprobanteFondoFijoController@find')->where(['id' => '[0-9]+']);

        /**
         * Compras Routes
         */
        $api->get('compras/orden_compra/{id}', 'Ghi\Api\Controllers\v1\Compras\OrdenCompraController@find')->where(['id' => '[0-9]+']);
        $api->get('compras/orden_compra/search', 'Ghi\Api\Controllers\v1\Compras\OrdenCompraController@search');

        /**
         * Contratos Routes
         */
        $api->get('contratos/subcontrato/search', 'Ghi\Api\Controllers\v1\SubcontratoController@search');

        /**
         * Rubros Routes
         */
        $api->get('finanzas/rubro', 'Ghi\Api\Controllers\v1\Finanzas\RubroController@index');
    });
});

$api->version('v2' , function ($api) {
    $api->post('auth', 'Ghi\Api\Controllers\v2\Auth\AuthController@postLogin');
});
