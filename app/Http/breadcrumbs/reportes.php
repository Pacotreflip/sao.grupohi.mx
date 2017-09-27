<?php

/*
 * Reportes Breadcrumbs...
 */
Breadcrumbs::register('reportes.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('REPORTES', route('reportes.index'));
});

/*
 * Estimación Breadcrumbs
 */
Breadcrumbs::register('reportes.subcontratos.estimacion', function ($breadcrumb) {
    $breadcrumb->parent('reportes.index');
    $breadcrumb->push('ORDEN DE PAGO ESTIMACIÓN', route('reportes.subcontratos.estimacion'));
});