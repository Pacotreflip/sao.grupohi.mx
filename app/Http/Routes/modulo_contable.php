<?php

Route::group(['prefix' => 'modulo_contable'], function () {
    Route::get('/', 'PagesController@modulo_contable')->name('modulo_contable.index');

    /*
     * Poliza Tipo Routes...
     */
    Route::get('poliza_tipo', 'PolizaTipoController@index')->name('modulo_contable.poliza_tipo.index');
    Route::get('poliza_tipo/findBy', 'PolizaTipoController@findBy');
    Route::get('poliza_tipo/create', 'PolizaTipoController@create')->name('modulo_contable.poliza_tipo.create');
    Route::delete('poliza_tipo/{id}', 'PolizaTipoController@destroy')->name('modulo_contable.poliza_tipo.destroy')->where(['id'=>'[0-9]+']);
    Route::get('poliza_tipo/{id}', 'PolizaTipoController@show')->name('modulo_contable.poliza_tipo.show')->where(['id'=>'[0-9]+']);
    Route::post('poliza_tipo', 'PolizaTipoController@store');
    Route::get('poliza_tipo/{id}/check_fecha', 'PolizaTipoController@check_fecha');

    /*
     * Cuenta Contable Routes...
     */
    Route::get('cuenta_contable', 'CuentaContableController@index')->name('modulo_contable.cuenta_contable.index');

    /*
     * Tipo Cuenta Contable Routes.....
     */
    Route::get('tipo_cuenta_contable', 'TipoCuentaContableController@index')->name('modulo_contable.tipo_cuenta_contable.index');
    Route::get('tipo_cuenta_contable/create', 'TipoCuentaContableController@create')->name('modulo_contable.tipo_cuenta_contable.create');
    Route::delete('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@destroy')->name('modulo_contable.tipo_cuenta_contable.destroy')->where(['id'=>'[0-9]+']);
});