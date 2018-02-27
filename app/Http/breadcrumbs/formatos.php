<?php

/*
 * Formatos Breadcrumbs...
 */
Breadcrumbs::register('formatos.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('FORMATOS', route('formatos.index'));
});

/*
 * Estimación Breadcrumbs
 */
Breadcrumbs::register('formatos.subcontratos.estimacion', function ($breadcrumb) {
    $breadcrumb->parent('formatos.index');
    $breadcrumb->push('ORDEN DE PAGO ESTIMACIÓN', route('formatos.subcontratos.estimacion'));
});