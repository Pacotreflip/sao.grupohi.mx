<?php

Route::group(['prefix' => 'compras'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@compras')->name('compras.index');

    /**
     * Requisición Routes...
     */
    Route::get('requisicion', 'Compras\RequisicionController@index')->name('compras.requisicion.index');
    Route::get('requisicion/{id}', 'Compras\RequisicionController@show')->name('compras.requisicion.show')->where(['id' => '[0-9]+']);
    Route::get('requisicion/{id}/edit', 'Compras\RequisicionController@edit')->name('compras.requisicion.edit')->where(['id' => '[0-9]+']);
    Route::get('requisicion/create', 'Compras\RequisicionController@create')->name('compras.requisicion.create');
    Route::post('requisicion', 'Compras\RequisicionController@store')->name('compras.requisicion.store');
    Route::patch('requisicion/{id}', 'Compras\RequisicionController@update')->name('compras.requisicion.update')->where(['id' => '[0-9]+']);
    Route::delete('requisicion/{id}', 'Compras\RequisicionController@destroy')->name('compras.requisicion.destroy')->where(['id' => '[0-9]+']);

    /**
     * Materiles Routes

    Route::get('material', 'Compras\MaterialController@index')->name('compras.material.index');
    Route::get('material/{id}/tipo', 'Compras\MaterialController@findBy')->name('compras.material.findby')->where(['id' => '[0-9]+']);
    Route::get('material/{id}', 'Compras\MaterialController@show')->name('compras.material.show')->where(['id' => '[0-9]+']);
    Route::get('material/{id}/edit', 'Compras\MaterialController@edit')->name('compras.material.edit')->where(['id' => '[0-9]+']);
    Route::get('material/create', 'Compras\MaterialController@create')->name('compras.material.create');
    Route::post('material', 'Compras\MaterialController@store')->name('compras.material.store');
    Route::patch('material/{id}', 'Compras\MaterialController@update')->name('compras.material.update')->where(['id' => '[0-9]+']);
    Route::delete('material/{id}', 'Compras\MaterialController@destroy')->name('compras.material.destroy')->where(['id' => '[0-9]+']);
     */

});

