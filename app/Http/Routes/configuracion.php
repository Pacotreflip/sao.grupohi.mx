<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/12/2017
 * Time: 07:01 PM
 */


Route::group(['prefix' => 'configuracion'], function () {

    /**
     * Cierre de Periodo routes
     */
    Route::get('cierre', 'CierreController@index')->name('configuracion.cierre.index');
    Route::post('cierre/paginate', 'CierreController@paginate');
    Route::get('cierre/create', 'CierreController@create')->name('configuracion.cierre.create');
    Route::post('cierre', 'CierreController@store')->name('configuracion.cierre.store');
    Route::get('cierre/{cierre}', 'CierreController@show')->name('configuracion.cierre.show');
});
