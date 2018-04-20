<?php

Route::group(['prefix' => 'finanzas', 'middleware' => 'system.access:finanzas'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@finanzas')->name('finanzas.index');

    /**
     * Comprobante de fondo fijo routes
     */
    Route::get('comprobante_fondo_fijo', 'ComprobanteFondoFijoController@index')->name('finanzas.comprobante_fondo_fijo.index');
    Route::get('comprobante_fondo_fijo/create', 'ComprobanteFondoFijoController@create')->name('finanzas.comprobante_fondo_fijo.create');
    Route::post('comprobante_fondo_fijo', 'ComprobanteFondoFijoController@store')->name('finanzas.comprobante_fondo_fijo.store');
    Route::get('comprobante_fondo_fijo/{id}/edit', 'ComprobanteFondoFijoController@edit')->name('finanzas.comprobante_fondo_fijo.edit')->where(['id' => '[0-9]+']);
    Route::get('comprobante_fondo_fijo/{id}', 'ComprobanteFondoFijoController@show')->name('finanzas.comprobante_fondo_fijo.show')->where(['id' => '[0-9]+']);
    Route::delete('comprobante_fondo_fijo/{id}', 'ComprobanteFondoFijoController@destroy')->name('finanzas.comprobante_fondo_fijo.destroy')->where(['id' => '[0-9]+']);
    Route::patch('comprobante_fondo_fijo/{id}', 'ComprobanteFondoFijoController@update')->name('finanzas.comprobante_fondo_fijo.update')->where(['id' => '[0-9]+']);
    Route::post('comprobante_fondo_fijo/paginate', 'ComprobanteFondoFijoController@paginate')->name('finanzas.comprobante_fondo_fijo.paginate');
 /**
  * Materiales
  */

    Route::get('material/getBy', 'MaterialController@getBy')->name('finanzas.material.getBy');
    Route::get('material/getBySinFamilias', 'MaterialController@getBySinFamilias')->name('finanzas.material.getBySinFamilias');

    Route::get('comprobante_fondo_fijo/getBy', 'ComprobanteFondoFijoController@getBy')->name('finanzas.comprobante_fondo_fijo.getBy');
});
