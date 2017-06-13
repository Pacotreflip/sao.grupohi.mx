<?php

Route::group(['prefix' => 'modulo_contable'], function () {
    Route::get('/', 'PagesController@modulo_contable')->name('modulo_contable.index');

    /*
     * Poliza Tipo Routes...
     */
    Route::get('poliza_tipo', 'PolizaTipoController@index')->name('modulo_contable.poliza_tipo.index');
    Route::get('poliza_tipo/create', 'PolizaTipoController@create')->name('modulo_contable.poliza_tipo.create');
    Route::get('poliza_tipo/{id}', 'PolizaTipoController@delete')->name('modulo_contable.poliza_tipo.delete')->where(['id'=>'[0-9]+']);
    Route::get('poliza_tipo/{id}', 'PolizaTipoController@show')->name('modulo_contable.poliza_tipo.show')->where(['id'=>'[0-9]+']);
    Route::post('poliza_tipo', 'PolizaTipoController@store');

    /*
     * Cuenta Contable Routes...
     */
    Route::get('cuenta_contable/{id}', 'CuentaContableController@getById');
});