<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 13/09/2017
 * Time: 01:30 PM
 */

Route::group(['prefix' => 'reportes'], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@reportes')->name('reportes.index');

    /**
     * Subcontratos Reportes Routes...
     */
    Route::get('subcontratos/estimacion', 'ReportesController@estimacion')->name('reportes.subcontratos.estimacion');
    Route::get('subcontratos/estimacion/{id}', 'ReportesController@estimacion_pdf')->name('reportes.subcontratos.estimacion.pdf')->where(['id' => '[0-9]+']);

});