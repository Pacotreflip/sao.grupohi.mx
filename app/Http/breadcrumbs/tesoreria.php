<?php

Breadcrumbs::register('tesoreria.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('TESORERÍA', route('tesoreria.index'));
});

/**
 * Traspaso entre cuentas
 */
Breadcrumbs::register('tesoreria.traspaso_cuentas.index', function($breadcrumbs) {
    $breadcrumbs->parent('tesoreria.index');
    $breadcrumbs->push('TRASPASO ENTRE CUENTAS', route('tesoreria.traspaso_cuentas.index'));
});

/**
 * Intereses
 */
Breadcrumbs::register('tesoreria.movimientos_bancarios.index', function($breadcrumbs) {
    $breadcrumbs->parent('tesoreria.index');
    $breadcrumbs->push('MOVIMIENTOS BANCARIOS', route('tesoreria.movimientos_bancarios.index'));
});

