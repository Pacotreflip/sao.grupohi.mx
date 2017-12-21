<?php

Route::group(['prefix' => 'control_costos'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@control_costos')->name('control_costos.index');

    /**
     * Solicitar reclasificación de costos
     */
    Route::get('solicitar_reclasificacion', 'SolicitarReclasificacionController@index')->name('control_costos.solicitar_reclasificacion.index');
    Route::get('solicitar_reclasificacion/find', 'SolicitarReclasificacionController@find')->name('control_costos.solicitar_reclasificacion.find');
    Route::post('solicitar_reclasificacion', 'SolicitarReclasificacionController@store')->name('control_costos.solicitar_reclasificacion.store');
    Route::get('solicitar_reclasificacion/tipos', 'SolicitarReclasificacionController@tipos')->name('control_costos.solicitar_reclasificacion.tipos');

    /**
     * Movimientos Bancarios
     */
    Route::get('reclasificacion_costos', 'ReclasificacionCostosController@index')->name('control_costos.reclasificacion_costos.index');
});
