<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 11:03
 */

Route::group(['prefix' => 'procuracion', 'middleware' => 'system.access:procuracion'], function () {
    Route::get('/', 'PagesController@procuracion')->name('procuracion.index');

    Route::get('asignacion', 'Procuracion\AsignacionController@index')->name('procuracion.asignacion.index');
    Route::get('asignacion/create', 'Procuracion\AsignacionController@create')->name('procuracion.asignacion.create');
});
