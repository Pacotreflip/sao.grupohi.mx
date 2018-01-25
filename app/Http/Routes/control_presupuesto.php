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
});