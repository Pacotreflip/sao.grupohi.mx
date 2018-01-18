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
     * Mostrar Solicitudes de cambio al presupuesto
     */
    Route::get('cambio_presupuesto', 'CtrlCambiosPresupuestoController@index')->name('control_presupuesto.cambio_presupuesto.index');
    Route::get('cambio_presupuesto/create', 'CtrlCambiosPresupuestoController@create')->name('control_presupuesto.cambio_presupuesto.create');


});