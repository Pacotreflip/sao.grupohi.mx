<?php


//Pages
Route::get('obras', 'PagesController@obras')->name('obras');

Route::group(['middleware' => 'context'], function () {
    Route::get('/', 'PagesController@index')->name('index');
});

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
 * Notificaciones
 */
Route::get('notificacion', 'NotificacionController@index')->name('notificacion');
Route::get('notificacion/{id}', 'NotificacionController@show')->name('notificacion.show');
Route::post('notificacion', 'NotificacionController@notificaciones')->name('notificacion.notificaciones');



