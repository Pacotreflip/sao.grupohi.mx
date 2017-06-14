<?php

/*
* API Routes
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {});