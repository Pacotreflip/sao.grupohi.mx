<?php


//Pages
Route::get('/', 'PagesController@welcome')->name('welcome');
Route::get('obras', 'PagesController@obras')->name('obras');

Route::group(['middleware' => 'context'], function () {
    Route::get('index', 'PagesController@index')->name('index');
});

//Contexto
Route::get('/context/{database}/{id_obra}','ContextoController@set')->name('context.set')->where(['databaseName'=>'[aA-zZ0-9_-]+','id_obra'=>'[0-9]+']);

//Login
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin')->name('auth.postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.getLogout');