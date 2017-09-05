<?php

Route::group(['prefix' => 'finanzas'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@finanzas')->name('finanzas.index');

    /**
     * Comprobante de fondo fijo routes
     */
    Route::get('comprobante_fondo_fijo', 'ComprobanteFondoFijoController@index')->name('finanzas.comprobante_fondo_fijo.index');
    Route::get('comprobante_fondo_fijo/create', 'ComprobanteFondoFijoController@create')->name('finanzas.comprobante_fondo_fijo.create');
    Route::post('comprobante_fondo_fijo/{id}', 'ComprobanteFondoFijoController@store')->name('finanzas.comprobante_fondo_fijo.store')->where(['id' => '[0-9]+']);;
    Route::post('comprobante_fondo_fijo/{id}', 'ComprobanteFondoFijoController@destroy')->name('finanzas.comprobante_fondo_fijo.destroy')->where(['id' => '[0-9]+']);;


});
