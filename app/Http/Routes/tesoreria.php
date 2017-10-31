<?php

Route::group(['prefix' => 'tesoreria'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@tesoreria')->name('tesoreria.index');

    /**
     * Traspaso entre cuentas
     */
    Route::get('traspaso_cuentas', 'TraspasoCuentasController@index')->name('tesoreria.traspaso_cuentas.index');
    Route::post('traspaso_cuentas', 'TraspasoCuentasController@store')->name('tesoreria.traspaso_cuentas.store');
    Route::patch('traspaso_cuentas/{id}', 'TraspasoCuentasController@update')->name('tesoreria.traspaso_cuentas.update');
    Route::get('traspaso_cuentas/{id}', 'TraspasoCuentasController@destroy')->name('tesoreria.traspaso_cuentas.destroy')->where(['id' => '[0-9]+']);
});
