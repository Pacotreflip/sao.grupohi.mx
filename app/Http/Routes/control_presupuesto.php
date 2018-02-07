<?php

Route::group(['prefix' => 'control_presupuesto'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@control_presupuesto')->name('control_presupuesto.index');
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
     * Materiales insumos
     */

    Route::get('cambio_presupuesto/getDescripcionByTipo', 'MaterialController@getDescripcionByTipo')->name('control_presupuesto.cambio_presupuesto.getDescripcionByTipo');
});