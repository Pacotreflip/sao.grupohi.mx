<?php
/*
 * Compras Breadcrumbs...
 */
Breadcrumbs::register('finanzas.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SISTEMA DE FINANZAS', route('finanzas.index'));
});
