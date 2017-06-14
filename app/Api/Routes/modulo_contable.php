<?php

/*
 * Módulo Contable Api Routes...
 */
$api->group(['prefix' => 'modulo_contable'], function ($api) {

    //Plantillas de Póliza Routes
    $api->get('poliza_tipo/{id_poliza_tipo}', 'Ghi\Api\Controllers\PolizaTipoController@find');
    $api->post('poliza_tipo', 'Ghi\Api\Controllers\PolizaTipoController@store');
    $api->delete('poliza_tipo/{id_poliza_tipo}', 'Ghi\Api\Controllers\PolizaTipoController@delete');
});