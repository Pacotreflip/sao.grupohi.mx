<?php

Breadcrumbs::register('index', function ($b) {
    $b->push('INICIO', route('index'));
});

include ('breadcrumbs/modulo_contable.php');
