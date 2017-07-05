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
    Route::get('requisicion/create', 'Compras\RequisicionController@create')->name('compras.requisicion.create');
    Route::post('requisicion', 'Compras\RequisicionController@store')->name('compras.requisicion.store');

});

