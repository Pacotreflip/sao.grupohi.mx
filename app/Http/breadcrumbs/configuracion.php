<?php

/*
 * Cierre de Periodo Breadcrumbs...
 */
Breadcrumbs::register('configuracion.cierre.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('CIERRE DE PERIODO', route('configuracion.cierre.index'));
});