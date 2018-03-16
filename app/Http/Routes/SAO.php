<?php

//Usuarios Routes...

Route::get('test', function () {
    dd(\Ghi\Domain\Core\Models\ConceptoPath::getColumnsAttribute());
});

Route::post('usuario/paginate', 'UsuarioController@paginate');
Route::get('usuario/{usuario}', 'UsuarioController@find');
Route::post('usuario', 'UsuarioController@saveRoles');
//Pages
Route::get('obras', 'PagesController@obras')->name('obras');

Route::get('/', 'PagesController@index')->name('index');

//Contexto
Route::get('/context/{database}/{id_obra}','ContextoController@set')->name('context.set')->where(['databaseName'=>'[aA-zZ0-9_-]+','id_obra'=>'[0-9]+']);

//Login
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin')->name('auth.postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.getLogout');

/**
 * Item Routes...
 */
Route::post('item', 'ItemController@store')->name('item.store');
Route::patch('item/{id}', 'ItemController@update')->name('item.update')->where(['id' => '[0-9]+']);
Route::delete('item/{id}', 'ItemController@destroy')->name('item.destroy')->where(['id' => '[0-9]+']);

/**
 * Obra Routes...
 */
Route::get('obra/search', 'ObraController@search')->name('obra.search');

/**
 * Material Routes...
 */
Route::get('material', 'MaterialController@index')->name('material.index');
Route::get('material/getFamiliasByTipo', 'MaterialController@getFamiliasByTipo')->name('materiales.getFamiliasByTipo');
Route::get('material/getFamiliasByTipoPadres', 'MaterialController@getFamiliasByTipoPadres')->name('materiales.getFamiliasByTipoPadres');
Route::get('material/{id}/getHijos', 'MaterialController@getHijos')->name('material.getHijos');
Route::post('material', 'MaterialController@store')->name('material.store');

/**
 * Conceptos Routes
 */

Route::get('conceptos/jstree', 'ConceptoController@getRoot');
Route::get('conceptos/{id}/jstree', 'ConceptoController@getNode');
Route::post('conceptos/getPaths', 'ConceptoController@getPaths');
Route::post('conceptos/getPathsConceptos', 'ConceptoController@getPathsConceptos');
Route::get('conceptos/getPathsCostoIndirecto', 'ConceptoController@getPathsCostoIndirecto');
Route::get('conceptos/{id}', 'ConceptoController@show');
Route::get('conceptos/{id}/getInsumos', 'ConceptoController@getInsumos');

/**
 * Subcontratos Routes...
 */
Route::get('subcontrato', 'SubcontratoController@index')->name('subcontrato.index');
Route::get('subcontrato/getBy', 'SubcontratoController@getBy');

/**
 * Estimaciones Routes...
 */
Route::get('estimacion', 'EstimacionController@index')->name('estimacion.index');
Route::get('estimacion/getBy', 'EstimacionController@getBy');

/**
 * Almacen tree Routes...
 */

Route::get('almacen/jstree', 'AlmacenController@getRoot');
Route::get('almacen/{id}/jstree', 'AlmacenController@getNode');
Route::get('almacen/{id}', 'AlmacenController@show');
Route::post('almacen/paginate', 'AlmacenController@paginate');

/**
 * Tipo Tran Routes...
 */
Route::get('tipo_tran/lists', 'TipoTranController@lists');

/**
 * Unidades
 */
Route::get('unidad/getUnidadesByDescripcion', 'UnidadController@getUnidadesByDescripcion')->name('unidad.getUnidadesByDescripcion');