<?php

Route::group(['prefix' => 'compras'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@compras')->name('compras.index');

    /**
     * Requisición Routes...
     */
    Route::get('requisicion', 'RequisicionController@index')->name('compras.requisicion.index');
    Route::get('requisicion/{id}', 'RequisicionController@show')->name('compras.requisicion.show')->where(['id' => '[0-9]+']);
    Route::get('requisicion/create', 'RequisicionController@create')->name('compras.requisicion.create');
    Route::post('requisicion', 'RequisicionController@store')->name('compras.requisicion.store');

});

