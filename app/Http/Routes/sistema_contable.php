<?php

Route::group(['prefix' => 'sistema_contable'], function () {
    Route::get('/', 'PagesController@sistema_contable')->name('sistema_contable.index');

    /*
     * Poliza Tipo Routes...
     */
    Route::get('poliza_tipo', 'PolizaTipoController@index')->name('sistema_contable.poliza_tipo.index');
    Route::get('poliza_tipo/findBy', 'PolizaTipoController@findBy');
    Route::get('poliza_tipo/create', 'PolizaTipoController@create')->name('sistema_contable.poliza_tipo.create');
    Route::delete('poliza_tipo/{id}', 'PolizaTipoController@destroy')->name('sistema_contable.poliza_tipo.destroy')->where(['id' => '[0-9]+']);
    Route::get('poliza_tipo/{id}', 'PolizaTipoController@show')->name('sistema_contable.poliza_tipo.show')->where(['id' => '[0-9]+']);
    Route::post('poliza_tipo', 'PolizaTipoController@store');
    Route::get('poliza_tipo/{id}/check_fecha', 'PolizaTipoController@check_fecha');

    /*
     * Cuenta Contable Routes...
     */
    Route::get('cuenta_contable', 'CuentaContableController@index')->name('sistema_contable.cuenta_contable.index');
    Route::post('cuenta_contable', 'CuentaContableController@store')->name('sistema_contable.cuenta_contable.store');
    Route::patch('cuenta_contable/{cuenta_contable}', 'CuentaContableController@update')->name('sistema_contable.cuenta_contable.update');
    Route::get('cuenta_contable/findBy', 'CuentaContableController@findBy')->name('sistema_contable.cuenta_contable.findby');

    /**
     * Tipo Cuenta Contable Routes.....
     */
    Route::get('tipo_cuenta_contable', 'TipoCuentaContableController@index')->name('sistema_contable.tipo_cuenta_contable.index');
    Route::get('tipo_cuenta_contable/create', 'TipoCuentaContableController@create')->name('sistema_contable.tipo_cuenta_contable.create');
    Route::delete('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@destroy')->name('sistema_contable.tipo_cuenta_contable.destroy')->where(['id'=>'[0-9]+']);
    Route::get('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@show')->name('sistema_contable.tipo_cuenta_contable.show')->where(['id'=>'[0-9]+']);
    Route::post('tipo_cuenta_contable', 'TipoCuentaContableController@store');

    /**
     * Datos Contables
     */
    Route::get('datos_contables/findBy', 'DatosContablesController@findBy');
    Route::patch('datos_contables/{datos_contables}', 'DatosContablesController@update')->name('sistema_contable.datos_contables.update');

    /**
     * Polizas Generadas
     */
    Route::get('poliza_generada', 'PolizaController@index')->name('sistema_contable.poliza_generada.index');
    Route::get('poliza_generada/{id}', 'PolizaController@show')->name('sistema_contable.poliza_generada.show')->where(['id' => '[0-9]+']);
    Route::get('poliza_generada/{id}/edit', 'PolizaController@edit')->name('sistema_contable.poliza_generada.edit')->where(['id' => '[0-9]+']);
    Route::get('poliza_generada/{poliza}/historico', 'PolizaHistoricoController@index')->name('sistema_contable.poliza_generada.historico')->where(['id' => '[0-9]+']);
    Route::patch('poliza_generada/{id}', 'PolizaController@update')->name('sistema_contable.poliza_generada.update')->where(['id' => '[0-9]+']);

    /**
     * Relación Cuentas Concepto
     */
    Route::get('cuenta_concepto', 'CuentaConceptoController@index')->name('sistema_contable.cuenta_concepto.index');
    Route::patch('cuenta_concepto/{id}', 'CuentaConceptoController@update')->name('sistema_contable.cuenta_concepto.update');
    Route::post('cuenta_concepto', 'CuentaConceptoController@store')->name('sistema_contable.cuenta_concepto.store');

    /**
     * Conceptos
     */
    Route::get('concepto/findBy', 'ConceptoController@findBy')->name('sistema_contable.concepto.findby');
    Route::get('concepto/getBy', 'ConceptoController@getBy')->name('sistema_contable.concepto.getBy');

    /**
     * Cuentas Almacens Routes...
     */
    Route::get('cuenta_almacen', 'CuentaAlmacenController@index')->name('sistema_contable.cuenta_almacen.index');
    Route::post('cuenta_almacen', 'CuentaAlmacenController@store')->name('sistema_contable.cuenta_almacen.store');
    Route::patch('cuenta_almacen/{id}', 'CuentaAlmacenController@update')->name('sistema_contable.cuenta_almacen.update')->where(['id' => '[0-9]+']);

    /*
     * Cuentas de Empresa
     */

    Route::get('cuenta_empresa', 'CuentaEmpresaController@index')->name('sistema_contable.cuenta_empresa.index');
    Route::post('cuenta_empresa', 'CuentaEmpresaController@store')->name('sistema_contable.cuenta_empresa.store');
    Route::get('cuenta_empresa/{id}/edit', 'CuentaEmpresaController@edit')->name('sistema_contable.cuenta_empresa.edit')->where(['id' => '[0-9]+']);
    Route::get('cuenta_empresa/{id}', 'CuentaEmpresaController@show')->name('sistema_contable.cuenta_empresa.show')->where(['id' => '[0-9]+']);
    Route::delete('cuenta_empresa/{id}', 'CuentaEmpresaController@delete')->name('sistema_contable.cuenta_empresa.delete')->where(['id' => '[0-9]+']);
    Route::patch('cuenta_empresa/{id}', 'CuentaEmpresaController@update')->name('sistema_contable.cuenta_empresa.update')->where(['id' => '[0-9]+']);

    /*
     * Datos Contables Routes...
     */
    Route::get('datos_contables/{id}/edit', 'DatosContablesController@edit')->name('sistema_contable.datos_contables.edit');

    /**
     * Kardex Materiales
     */
    Route::get('kardex_material', 'kardexMaterialController@index')->name('sistema_contable.kardex_material.index');
    Route::get('kardex_material/{id}', 'ItemController@getBy')->name('sistema_contable.kardex_material.getBy')->where(['id' => '[0-9]+']);

    /*
     *  Cuentas de Materiales
     */
    Route::get('cuenta_material', 'CuentaMaterialController@index')->name('sistema_contable.cuenta_material.index');
    Route::get('cuenta_material/{id}', 'CuentaMaterialController@findBy')->name('sistema_contable.cuenta_material.findby')->where(['id' => '[0-9]+']);
    Route::get('cuenta_material/{tipo}/material/{nivel}', 'CuentaMaterialController@show')->name('sistema_contable.cuenta_material.show');
    Route::post('cuenta_material', 'CuentaMaterialController@store')->name('sistema_contable.cuenta_material.store');
    Route::patch('cuenta_material/{id}', 'CuentaMaterialController@update')->name('sistema_contable.cuenta_material.update')->where(['id' => '[0-9]+']);


});
