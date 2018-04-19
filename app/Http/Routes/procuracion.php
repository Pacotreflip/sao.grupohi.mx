<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 11:03
 */

Route::group(['prefix' => 'procuracion', 'middleware' => 'system.access:procuracion'], function () {
    Route::get('/', 'PagesController@procuracion')->name('procuracion.index');

    Route::get('asignacion', 'AsignacionControllers@index')->name('procuracion.asignacion.index');
    Route::get('asignacion/create', 'AsignacionControllers@index')->name('procuracion.asignacion.create');
});
