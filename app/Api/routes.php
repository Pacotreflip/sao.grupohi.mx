<?php

/*
* API Routes
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {
    /*
     * Cuentas Contables API Routes
     */
    $api->group(['prefix' => 'cuenta_contable'], function ($api) {
        $api->get('/{id}', 'Ghi\Api\Controllers\CuentaContableController@getById');
    });
});