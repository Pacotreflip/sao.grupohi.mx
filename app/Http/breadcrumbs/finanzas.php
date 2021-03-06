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

Breadcrumbs::register('finanzas.comprobante_fondo_fijo.create', function ($breadcrumb) {
    $breadcrumb->parent('finanzas.comprobante_fondo_fijo.index');
    $breadcrumb->push('NUEVO', route('finanzas.comprobante_fondo_fijo.create'));
});

Breadcrumbs::register('finanzas.comprobante_fondo_fijo.edit', function ($breadcrumb, $comprobante_fondo_fijo) {
    $breadcrumb->parent('finanzas.comprobante_fondo_fijo.show',$comprobante_fondo_fijo);
    $breadcrumb->push("EDITAR", route('finanzas.comprobante_fondo_fijo.edit', $comprobante_fondo_fijo));
});


Breadcrumbs::register('finanzas.comprobante_fondo_fijo.show', function ($breadcrumb, $comprobante_fondo_fijo) {
    $breadcrumb->parent('finanzas.comprobante_fondo_fijo.index');
    $breadcrumb->push('# ' . mb_strtoupper($comprobante_fondo_fijo->numero_folio), route('finanzas.comprobante_fondo_fijo.show', $comprobante_fondo_fijo));
});


/*
 * Solicitud de Cheque Breadcrumbs...
 */
Breadcrumbs::register('finanzas.solicitud_cheque.create', function ($breadcrumb) {
    $breadcrumb->parent('finanzas.index');
    $breadcrumb->push('NUEVA SOLICITUD DE CHEQUE', route('finanzas.solicitud_cheque.create'));
});