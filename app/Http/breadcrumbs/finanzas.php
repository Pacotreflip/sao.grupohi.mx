<?php
/*
 * Compras Breadcrumbs...
 */
Breadcrumbs::register('finanzas.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SISTEMA DE FINANZAS', route('finanzas.index'));
});

/*
 * Comprobantes de fondo Fijo Breadcrumbs...
 */
Breadcrumbs::register('finanzas.comprobante_fondo_fijo.index', function ($breadcrumb) {
    $breadcrumb->parent('finanzas.index');
    $breadcrumb->push('COMPROBANTES DE FONDO FIJO', route('finanzas.comprobante_fondo_fijo.index'));
});
