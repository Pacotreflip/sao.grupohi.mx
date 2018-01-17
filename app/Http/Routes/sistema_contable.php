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
    Route::delete('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@destroy')->name('sistema_contable.tipo_cuenta_contable.destroy')->where(['id' => '[0-9]+']);
    Route::get('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@show')->name('sistema_contable.tipo_cuenta_contable.show')->where(['id' => '[0-9]+']);
    Route::get('tipo_cuenta_contable/{id}/edit', 'TipoCuentaContableController@edit')->name('sistema_contable.tipo_cuenta_contable.edit')->where(['id' => '[0-9]+']);
    Route::post('tipo_cuenta_contable', 'TipoCuentaContableController@store');
    Route::patch('tipo_cuenta_contable/{id}', 'TipoCuentaContableController@update')->name('sistema_contable.tipo_cuenta_contable.update')->where(['id' => '[0-9]+']);

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
    Route::patch('poliza_generada/{id}/ingresar_folio', 'PolizaController@ingresarFolio')->name('sistema_contable.poliza_generada.ingresar_folio')->where(['id' => '[0-9]+']);

    /**
     * Relación Cuentas Concepto
     */
    Route::get('cuenta_concepto', 'CuentaConceptoController@index')->name('sistema_contable.cuenta_concepto.index');
    Route::patch('cuenta_concepto/{id}', 'CuentaConceptoController@update')->name('sistema_contable.cuenta_concepto.update');
    Route::post('cuenta_concepto', 'CuentaConceptoController@store')->name('sistema_contable.cuenta_concepto.store');
    Route::post('cuenta_concepto/searchNodo', 'CuentaConceptoController@searchNodo')->name('sistema_contable.cuenta_concepto.searchNodo');

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
    Route::delete('cuenta_empresa/{id}', 'CuentaEmpresaController@destroy')->name('sistema_contable.cuenta_empresa.delete')->where(['id' => '[0-9]+']);
    Route::patch('cuenta_empresa/{id}', 'CuentaEmpresaController@update')->name('sistema_contable.cuenta_empresa.update')->where(['id' => '[0-9]+']);

    /*
     * Datos Contables Routes...
     */
    Route::get('datos_contables/{id}/edit', 'DatosContablesController@edit')->name('sistema_contable.datos_contables.edit');

    /**
     * Kardex Materiales
     */
    Route::get('kardex_material', 'kardexMaterialController@index')->name('sistema_contable.kardex_material.index');
    Route::get('kardex_material/{id}', 'ItemController@show')->name('sistema_contable.kardex_material.show')->where(['id' => '[0-9]+']);
    Route::get('kardex_material/getBy', 'kardexMaterialController@getBy')->name('sistema_contable.kardex_material.getBy');

    /*
     *  Cuentas de Materiales
     */
    Route::get('cuenta_material', 'CuentaMaterialController@index')->name('sistema_contable.cuenta_material.index');
    Route::get('cuenta_material/{id}', 'CuentaMaterialController@findBy')->name('sistema_contable.cuenta_material.findby')->where(['id' => '[0-9]+']);
    Route::get('cuenta_material/{tipo}/material/{nivel}', 'CuentaMaterialController@show')->name('sistema_contable.cuenta_material.show');
    Route::post('cuenta_material', 'CuentaMaterialController@store')->name('sistema_contable.cuenta_material.store');
    Route::patch('cuenta_material/{id}', 'CuentaMaterialController@update')->name('sistema_contable.cuenta_material.update')->where(['id' => '[0-9]+']);


    /**
     *
     * Notificaciones
     */
    Route::get('notificacion', 'NotificacionController@index')->name('sistema_contable.notificacion.index');
    Route::get('notificacion/{id}', 'NotificacionController@show')->name('sistema_contable.notificacion.show');

    /**
     * Poliza Movimientos
     */
    Route::get('poliza_movimientos/{id}', 'PolizaMovimientosController@edit')->name('sistema_contable.poliza_movimientos.edit')->where(['id' => '[0-9]+']);
    Route::patch('poliza_movimientos/{id}', 'PolizaMovimientosController@update')->name('sistema_contable.poliza_movimientos.update')->where(['id' => '[0-9]+']);

    /**
     * Revaluaciones
     */
    Route::get('revaluacion', 'RevaluacionesController@index')->name('sistema_contable.revaluacion.index');
    Route::get('revaluacion/create', 'RevaluacionesController@create')->name('sistema_contable.revaluacion.create');
    Route::post('revaluacion', 'RevaluacionesController@store')->name('sistema_contable.revaluacion.store');
    Route::get('revaluacion/{id}', 'RevaluacionesController@show')->name('sistema_contable.revaluacion.show')->where(['id' => '[0-9]+']);

    /**
     * Cuentas de Fondos
     */
    Route::get('cuenta_fondo', 'CuentaFondoController@index')->name('sistema_contable.cuenta_fondo.index');
    Route::post('cuenta_fondo', 'CuentaFondoController@store')->name('sistema_contable.cuenta_fondo.store');
    Route::get('cuenta_fondo/{id}', 'CuentaFondoController@show')->name('sistema_contable.cuenta_fondo.show')->where(['id' => '[0-9]+']);
    Route::patch('cuenta_fondo/{id}', 'CuentaFondoController@update')->name('sistema_contable.cuenta_fondo.update')->where(['id' => '[0-9]+']);

    /**
     * Cuentas Contables Bancarias
     */
    Route::get('cuentas_contables_bancarias', 'CuentaBancosController@index')->name('sistema_contable.cuentas_contables_bancarias.index');
    Route::post('cuentas_contables_bancarias', 'CuentaBancosController@store')->name('sistema_contable.cuentas_contables_bancarias.store');
    Route::get('cuentas_contables_bancarias/{id}/edit', 'CuentaBancosController@edit')->name('sistema_contable.cuentas_contables_bancarias.edit')->where(['id' => '[0-9]+']);
    Route::get('cuentas_contables_bancarias/{id}', 'CuentaBancosController@show')->name('sistema_contable.cuentas_contables_bancarias.show')->where(['id' => '[0-9]+']);
    Route::delete('cuentas_contables_bancarias/{id}', 'CuentaBancosController@destroy')->name('sistema_contable.cuentas_contables_bancarias.delete')->where(['id' => '[0-9]+']);
    Route::patch('cuentas_contables_bancarias/{id}', 'CuentaBancosController@update')->name('sistema_contable.cuentas_contables_bancarias.update')->where(['id' => '[0-9]+']);

    /**
     * Cuentas Costo
     */
    Route::get('cuenta_costo', 'CuentaCostoController@index')->name('sistema_contable.cuenta_costo.index');
    Route::patch('cuenta_costo/{id}', 'CuentaCostoController@update')->name('sistema_contable.cuenta_costo.update');
    Route::post('cuenta_costo', 'CuentaCostoController@store')->name('sistema_contable.cuenta_costo.store');
    Route::delete('cuenta_costo/{id}', 'CuentaCostoController@destroy')->name('sistema_contable.cuenta_costo.delete')->where(['id' => '[0-9]+']);
    Route::post('cuenta_costo/searchNodo', 'CuentaCostoController@searchNodo')->name('sistema_contable.cuenta_costo.searchNodo');

    /**
     * Costos
     */
    Route::get('costo/findBy', 'CostoController@findBy')->name('sistema_contable.costo.findBy');
    Route::get('costo/getBy', 'CostoController@getBy')->name('sistema_contable.costo.getBy');

    /**
     * Cierre de Periodo routes
     */
    Route::get('cierre', 'CierreController@index')->name('sistema_contable.cierre.index');
    Route::post('cierre/paginate', 'CierreController@paginate');
    Route::get('cierre/create', 'CierreController@create')->name('sistema_contable.cierre.create');
    Route::post('cierre', 'CierreController@store')->name('sistema_contable.cierre.store');
    Route::get('cierre/{cierre}', 'CierreController@show')->name('sistema_contable.cierre.show');
    Route::patch('cierre/{cierre}/open', 'CierreController@open');
    Route::patch('cierre/{cierre}/close', 'CierreController@close');
});
