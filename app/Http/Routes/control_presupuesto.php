<?php

Route::group(['prefix' => 'control_presupuesto'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@control_presupuesto')->name('control_presupuesto.index');

    /**
     * Solicitar reclasificación de costos
     */
    Route::get('presupuesto', 'PresupuestoController@index')->name('control_presupuesto.presupuesto.index');
    Route::post('conceptos/getPaths', 'PresupuestoController@getPaths');

    /**
     * Cambios en Presupuesto Routes
     */
    Route::get('cambio_presupuesto', 'CambioPresupuestoController@index')->name('control_presupuesto.cambio_presupuesto.index');
    Route::get('cambio_presupuesto/create', 'CambioPresupuestoController@create')->name('control_presupuesto.cambio_presupuesto.create');
    Route::post('cambio_presupuesto', 'CambioPresupuestoController@store')->name('control_presupuesto.cambio_presupuesto.store');
    Route::post('cambio_presupuesto/paginate', 'CambioPresupuestoController@paginate');
    Route::get('cambio_presupuesto/{id}/pdf', 'CambioPresupuestoController@pdf')->name('control_presupuesto.cambio_presupuesto.pdf');
    Route::get('cambio_presupuesto/{id}', 'CambioPresupuestoController@show')->name('control_presupuesto.cambio_presupuesto.show')->where(['id' => '[0-9]+']);
    Route::post('cambio_presupuesto/autorizarSolicitud', 'CambioPresupuestoController@autorizarSolicitud')->name('control_presupuesto.cambio_presupuesto.autorizarSolicitud');
    Route::post('cambio_presupuesto/rechazarSolicitud', 'CambioPresupuestoController@rechazarSolicitud')->name('control_presupuesto.cambio_presupuesto.rechazarSolicitud');

    /**
     * Variacion Volúmen Routes
     */
    Route::group(['prefix' => 'variacion_volumen'], function () {
        Route::get('/create', 'VariacionVolumenController@create')->name('control_presupuesto.variacion_volumen.create');
        Route::get('/{variacion_volumen}', 'VariacionVolumenController@show')->name('control_presupuesto.variacion_volumen.show')->where(['variacion_volumen' => '[0-9]+']);;
        Route::get('/getBasesAfectadas', 'VariacionVolumenController@getBasesAfectadas');
        Route::post('/', 'VariacionVolumenController@store');
        Route::post('/{variacion_volumen}/autorizar', 'VariacionVolumenController@autorizar');
        Route::post('/{variacion_volumen}/rechazar', 'VariacionVolumenController@rechazar');
        Route::post('/{variacion_volumen}/aplicar', 'VariacionVolumenController@aplicar');
        Route::get('/{variacion_volumen}/pdf', 'VariacionVolumenController@pdf');
        Route::post('/{variacion_volumen}/paginate', 'VariacionVolumenController@paginate');
    });

    /**
     * Escalatoria Routes
     */
    Route::group(['prefix' => 'escalatoria'], function () {
        Route::get('/create', 'EscalatoriaController@create')->name('control_presupuesto.escalatoria.create');
        Route::get('/{escalatoria}', 'EscalatoriaController@show')->name('control_presupuesto.escalatoria.show');
        Route::post('/', 'EscalatoriaController@store');
        Route::post('/{escalatoria}/autorizar', 'EscalatoriaController@autorizar');
        Route::post('/{escalatoria}/rechazar', 'EscalatoriaController@rechazar');
        Route::post('/{escalatoria}/aplicar', 'EscalatoriaController@aplicar');
        Route::get('/{escalatoria}/pdf', 'EscalatoriaController@pdf');
        Route::post('/{escalatoria}/paginate', 'EscalatoriaController@paginate');
    });

    /**
     * Ordenes de Cambio de Insumos
     */
    Route::group(['prefix' => 'cambio_insumos'], function () {
        Route::get('/create', 'CambioInsumosController@create')->name('control_presupuesto.cambio_insumos.create');
        Route::get('/{cambio_insumos}', 'CambioInsumosController@show')->name('control_presupuesto.cambio_insumos.show');
        Route::post('/', 'CambioInsumosController@store');
        Route::post('/{cambio_insumos}/autorizar', 'CambioInsumosController@autorizar');
        Route::post('/{cambio_insumos}/rechazar', 'CambioInsumosController@rechazar');
        Route::post('/{cambio_insumos}/aplicar', 'CambioInsumosController@aplicar');
        Route::get('/{cambio_insumos}/pdf', 'CambioInsumosController@pdf');
        Route::post('/{cambio_insumos}/paginate', 'CambioInsumosController@paginate');

    });


    /**
     * Ordenes de Cambio de Insumos
     */
    Route::group(['prefix' => 'cambio_insumos_indirecto'], function () {
        Route::get('/create', 'CambioInsumosController@indirecto')->name('control_presupuesto.cambio_insumos.costo_indirecto.create');
        Route::post('/', 'CambioInsumosController@storeIndirecto');
        Route::get('/{cambio_insumos}', 'CambioInsumosController@show')->name('control_presupuesto.cambio_insumos.show');
        Route::get('/{cambio_insumos}/pdf', 'CambioInsumosController@pdf');
       });

    /**
     * Ordenes de Cambio a Cantidad en Insumos
     */
    Route::group(['prefix' => 'cambio_cantidad_insumos'], function () {
        Route::get('/create', 'CambioCantidadInsumosController@create')->name('control_presupuesto.cambio_cantidad_insumos.create');
        Route::post('/store', 'CambioCantidadInsumosController@store');
        Route::post('/{cambio_cantidad}/autorizar', 'CambioCantidadInsumosController@autorizar');
        Route::post('/getAgrupacionFiltro', 'CambioCantidadInsumosController@getAgrupacionFiltro');
        Route::post('/getExplosionAgrupados', 'CambioCantidadInsumosController@getExplosionAgrupados');
        Route::post('/getExplosionAgrupadosPartidas', 'CambioCantidadInsumosController@getExplosionAgrupadosPartidas');
        Route::get('/{cambio_cantidad}', 'CambioCantidadInsumosController@show')->name('control_presupuesto.cambio_cantidad_insumos.show')->where(['cambio_cantidad' => '[0-9]+']);
        Route::get('/{cambio_insumos}/pdf', 'CambioCantidadInsumosController@pdf');
    });

    /**
     * Conceptos Extraordinarios
     */
    Route::group(['prefix' => 'conceptos_extraordinarios'], function () {
        Route::get('/create', 'Presupuesto\ConceptosExtraordinariosController@create')->name('control_presupuesto.conceptos_extraordinarios.create');
        Route::get('/{tipo}/extraordinario/{id}', 'Presupuesto\ConceptosExtraordinariosController@getExtraordinario')->name('control_presupuesto.conceptos_extraordinarios.getExtraordinario');
        Route::post('/store', 'Presupuesto\ConceptosExtraordinariosController@store');
        Route::get('/{id}', 'Presupuesto\ConceptosExtraordinariosController@show')->name('control_presupuesto.conceptos_extraordinarios.show')->where(['id' => '[0-9]+']);
        Route::post('/{id}/autorizar', 'Presupuesto\ConceptosExtraordinariosController@autorizar')->name('control_presupuesto.conceptos_extraordinarios.autorizar')->where(['id' => '[0-9]+']);
        Route::post('/{id}/rechazar', 'Presupuesto\ConceptosExtraordinariosController@rechazar')->name('control_presupuesto.conceptos_extraordinarios.rechazar');
        Route::get('/{cambio_insumos}/pdf', 'Presupuesto\ConceptosExtraordinariosController@pdf');
        Route::post('/guardarCatalogo', 'Presupuesto\ConceptosExtraordinariosController@guardarCatalogo')->name('control_presupuesto.conceptos_extraordinarios.guardarCatalogo');
        Route::post('/guardarPartida', 'Presupuesto\ConceptosExtraordinariosController@guardarPartida')->name('control_presupuesto.conceptos_extraordinarios.guardarPartida');
        Route::get('/getBy', 'Presupuesto\ConceptosExtraordinariosController@getBy')->name('control_presupuesto.conceptos_extraordinarios.getBy');
        Route::get('/getNivelHijos', 'Presupuesto\ConceptosExtraordinariosController@getNivelHijos')->name('control_presupuesto.conceptos_extraordinarios.getNivelHijos');
    });

    /**
     * Tipos de Cobrabilidad Routes
     */
    Route::get('tipo_cobrabilidad', 'TipoCobrabilidadController@index');

    /**
     * Tipos de Orden de Cambio Routes
     */
    Route::get('tipo_orden', 'TipoOrdenController@index');

    /**
     * Tarjetas Route
     */
    Route::get('tarjeta', 'TarjetaController@index');
    Route::get('tarjeta/lists', 'TarjetaController@lists');

    /**
     * SolicitudCambioPartida
     */
    Route::get('cambio_presupuesto_partida/{id}', 'SolicitudCambioPartidasController@mostrarAfectacion')->where(['id' => '[0-9]+']);
    Route::post('cambio_presupuesto_partida/detallePresupuesto', 'SolicitudCambioPartidasController@detallePresupuesto')->name('control_presupuesto.cambio_presupuesto_partida.detallePresupuesto');
    Route::post('cambio_presupuesto_partida/subtotalTarjeta', 'SolicitudCambioPartidasController@subtotalTarjeta')->name('control_presupuesto.cambio_presupuesto_partida.subtotalTarjeta');
    Route::post('cambio_presupuesto_partida/subtotalTarjetaShow', 'SolicitudCambioPartidasController@subtotalTarjetaShow')->name('control_presupuesto.cambio_presupuesto_partida.subtotalTarjetaShow');
    Route::post('afectacion_presupuesto/getBasesAfectadas', 'AfectacionOrdenPresupuestoController@getBasesAfectadas')->name('control_presupuesto.afectacion_presupuesto.getBasesAfectadas');

    /**
     * Solicitud insumos
     */

    Route::get('cambio_presupuesto/getDescripcionByTipo', 'MaterialController@getDescripcionByTipo')->name('control_presupuesto.cambio_presupuesto.getDescripcionByTipo');
    Route::post('cambio_presupuesto_partida/getClasificacionInsumos', 'SolicitudCambioPartidasController@getClasificacionInsumos')->name('control_presupuesto.cambio_presupuesto_partida.getClasificacionInsumos');


});