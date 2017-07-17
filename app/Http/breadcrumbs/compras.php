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

Breadcrumbs::register('compras.requisicion.create', function ($breadcrumb) {
    $breadcrumb->parent('compras.requisicion.index');
    $breadcrumb->push('NUEVA', route('compras.requisicion.create'));
});

Breadcrumbs::register('compras.requisicion.edit', function ($breadcrumb, $requisicion) {
    $breadcrumb->parent('compras.requisicion.show', $requisicion);
    $breadcrumb->push('EDICION', route('compras.requisicion.edit', $requisicion));
});

/*
 * Materiales Breadcrumbs
 */
Breadcrumbs::register('compras.material.index', function ($breadcrumb) {
    $breadcrumb->parent('compras.index');
    $breadcrumb->push('MATERIALES', route('compras.material.index'));
});

Breadcrumbs::register('compras.material.show', function ($breadcrumb, $material) {
    $breadcrumb->parent('compras.material.index');
    $breadcrumb->push($material->folio, route('compras.material.show', $material));
});

Breadcrumbs::register('compras.material.create', function ($breadcrumb) {
    $breadcrumb->parent('compras.material.index');
    $breadcrumb->push('NUEVA', route('compras.material.create'));
});

Breadcrumbs::register('compras.material.edit', function ($breadcrumb, $material) {
    $breadcrumb->parent('compras.material.show', $material);
    $breadcrumb->push('EDICION', route('compras.material.edit', $material));
});