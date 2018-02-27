<?php

Breadcrumbs::register('index', function ($b) {
    $b->push('INICIO', route('index'));
});

include ('breadcrumbs/sistema_contable.php');
include ('breadcrumbs/compras.php');
include ('breadcrumbs/finanzas.php');
include ('breadcrumbs/formatos.php');
include ('breadcrumbs/tesoreria.php');
include ('breadcrumbs/control_costos.php');
include ('breadcrumbs/control_presupuesto.php');
include ('breadcrumbs/configuracion.php');
