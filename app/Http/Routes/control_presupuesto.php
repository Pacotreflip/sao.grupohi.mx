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

    /**
     * Tipos de Cobrabilidad Routes
     */
    Route::get('tipo_cobrabilidad', 'TipoCobrabilidadController@index');
});