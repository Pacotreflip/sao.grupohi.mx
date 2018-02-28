<?php

Route::group(['prefix' => 'control_costos', 'middleware' => 'system.access:control_costos'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@control_costos')->name('control_costos.index');

    /**
     * Solicitar reclasificación de costos
     */
    Route::get('solicitar_reclasificacion', 'SolicitarReclasificacionController@index')->name('control_costos.solicitar_reclasificacion.index');
    Route::get('solicitar_reclasificacion/findmovimiento', 'SolicitarReclasificacionController@findmovimiento')->name('control_costos.solicitar_reclasificacion.findmovimiento');
    Route::get('solicitar_reclasificacion/findtransaccion', 'SolicitarReclasificacionController@findtransaccion')->name('control_costos.solicitar_reclasificacion.findtransaccion');
    Route::get('solicitar_reclasificacion/find', 'SolicitarReclasificacionController@find')->name('control_costos.solicitar_reclasificacion.find');
    Route::post('solicitar_reclasificacion', 'SolicitarReclasificacionController@store')->name('control_costos.solicitar_reclasificacion.store');
    Route::get('solicitar_reclasificacion/tipos', 'SolicitarReclasificacionController@tipos')->name('control_costos.solicitar_reclasificacion.tipos');
    Route::get('solicitar_reclasificacion/items/{id_concepto}/{id}', 'SolicitarReclasificacionController@items')->name('control_costos.solicitar_reclasificacion.items')->where(['id' => '[0-9]+', 'id_concepto' => '[0-9]+']);
    Route::get('solicitar_reclasificacion/single/{id}', 'SolicitarReclasificacionController@single')->name('control_costos.solicitar_reclasificacion.single')->where(['id' => '[0-9]+']);

    /**
     * Solicitudes de reclasificación
     */
    Route::get('solicitudes_reclasificacion', 'SolicitudesReclasificacionController@index')->name('control_costos.solicitudes_reclasificacion.index');
    Route::get('solicitudes_reclasificacion/paginate', 'SolicitudesReclasificacionController@paginate');
    Route::post('solicitudes_reclasificacion/store', 'SolicitudesReclasificacionController@store');
    Route::get('solicitudes_reclasificacion/generarpdf/{id}', 'SolicitudesReclasificacionController@generar_pdf')->where(['id' => '[0-9]+']);
});
