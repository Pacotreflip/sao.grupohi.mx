<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/12/2017
 * Time: 07:01 PM
 */


Route::group(['prefix' => 'configuracion'], function () {

    Route::group(['prefix' => 'seguridad'], function () {

        Route::get('/', 'PagesController@seguridad')->name('configuracion.seguridad.index');

        /**
         * Roles Routes
         */
        Route::get('role', 'Configuracion\RoleController@index');
        Route::post('role/{role}/savePermisions', 'RoleController@savePermissions');
        Route::delete('role/{role}', 'Configuracion\RoleController@destroy');
        Route::patch('role/{role}', 'Configuracion\RoleController@update');
        Route::post('role/paginate', 'Configuracion\RoleController@paginate');

        /**
         * Permission Routes
         */
        Route::get('permission', 'Configuracion\PermissionController@index');
        Route::post('permission', 'Configuracion\PermissionController@store');
        Route::delete('permission/{permission}', 'Configuracion\PermissionController@destroy');
        Route::patch('permission/{permission}', 'Configuracion\PermissionController@update');
    });
});
