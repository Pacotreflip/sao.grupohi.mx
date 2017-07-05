<?php

/*
 * Compras Breadcrumbs...
 */
Breadcrumbs::register('compras.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SISTEMA DE COMPRAS', route('compras.index'));
});

/*
 * Requisición Breadcrumbs
 */
Breadcrumbs::register('compras.requisicion.index', function ($breadcrumb) {
    $breadcrumb->parent('compras.index');
    $breadcrumb->push('REQUISICIONES', route('compras.requisicion.index'));
});
Breadcrumbs::register('compras.requisicion.show', function ($breadcrumb, $requisicion) {
    $breadcrumb->parent('compras.requisicion.index');
    $breadcrumb->push($requisicion->folio, route('compras.requisicion.show', $requisicion));
});