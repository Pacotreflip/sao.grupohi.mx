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
    Route::patch('cierre/{cierre}/open', 'CierreController@open');
    Route::patch('cierre/{cierre}/close', 'CierreController@close');


    Route::group(['prefix' => 'seguridad'], function () {

        Route::get('/', 'PagesController@seguridad')->name('configuracion.seguridad.index');

        /**
         * Roles Routes
         */
        Route::get('role', 'RoleController@index');
        Route::post('role/{role}/attachPermision', 'RoleController@attachPermission');
        Route::delete('role/{role}', 'RoleController@destroy');
        Route::patch('role/{role}', 'RoleController@update');

        /**
         * Permission Routes
         */
        Route::get('permission', 'PermissioController@index');
        Route::post('permission', 'PermissioController@store');
        Route::delete('permission/{permission}', 'PermissioController@destroy');
        Route::patch('permission/{permission}', 'PermissioController@update');
    });

});
