<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 13/09/2017
 * Time: 01:30 PM
 */

Route::group(['prefix' => 'formatos', 'middleware' => ['system.access:formatos','verify.logo']], function () {

    /**
     * Index Route...
     */
    Route::get('/', 'PagesController@formatos')->name('formatos.index');

    /**
     * Subcontratos Formatos Routes...
     */
    Route::get('subcontratos/estimacion', 'FormatosController@estimacion')->name('formatos.subcontratos.estimacion');
    Route::get('subcontratos/estimacion/{id}', 'FormatosController@estimacion_pdf')->name('formatos.subcontratos.estimacion.pdf')->where(['id' => '[0-9]+']);


    Route::get('contratos/contrato_proyectado/{id}/comparativa_cotizaciones_contrato', 'FormatosController@comparativa_cotizaciones_contrato_pdf')->where(['id' => '[0-9]+']);

    Route::get('compras/requisicion/{id}/comparativa_cotizaciones_compra', 'FormatosController@comparativa_cotizaciones_compra_pdf')->where(['id' => '[0-9]+']);
});