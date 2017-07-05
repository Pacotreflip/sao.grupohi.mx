<?php

Breadcrumbs::register('index', function ($b) {
    $b->push('INICIO', route('index'));
});

include ('breadcrumbs/sistema_contable.php');
include ('breadcrumbs/compras.php');
