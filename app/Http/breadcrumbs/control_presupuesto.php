<?php

Breadcrumbs::register('control_presupuesto.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('CONTROL PRESUPUESTO', route('control_presupuesto.index'));
});

/**
 * Reclasificación de costos
 */
Breadcrumbs::register('control_presupuesto.presupuesto.index', function($breadcrumbs) {
    $breadcrumbs->parent('control_presupuesto.index');
    $breadcrumbs->push('CONTROL PRESUPUESTO', route('control_presupuesto.presupuesto.index'));
});


/*
 * Control de cambios al presupuesto (index)
 */
Breadcrumbs::register('control_presupuesto.cambio_presupuesto.index', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.index');
    $breadcrumb->push('CONTROL DE CAMBIOS', route('control_presupuesto.cambio_presupuesto.index'));
});


/*
 * Control de cambios al presupuesto (Nuevo)
 */
Breadcrumbs::register('control_presupuesto.cambio_presupuesto.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVA SOLICITUD', route('control_presupuesto.cambio_presupuesto.create'));
});
/*
 * Control de cambios al presupuesto (Show)
 */
Breadcrumbs::register('control_presupuesto.cambio_presupuesto.show', function ($breadcrumb, $solicitud) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('#' . $solicitud->numero_folio, route('control_presupuesto.cambio_presupuesto.show', $solicitud));
});

/**
 * Variación de Volúmen
 */
Breadcrumbs::register('control_presupuesto.variacion_volumen.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVA VARIACIÓN DE VOLÚMEN', route('control_presupuesto.variacion_volumen.create'));
});

Breadcrumbs::register('control_presupuesto.variacion_volumen.show', function ($breadcrumb, $variacion_volumen) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('#' . $variacion_volumen->id, route('control_presupuesto.variacion_volumen.show', $variacion_volumen));
});

/**
 * Escalatoria create
 */
Breadcrumbs::register('control_presupuesto.escalatoria.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVA ESCALATORIA', route('control_presupuesto.escalatoria.create'));
});

/**
 * Escalatoria show
 */
Breadcrumbs::register('control_presupuesto.escalatoria.show', function ($breadcrumb, $escalatoria) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('#' . $escalatoria->numero_folio, route('control_presupuesto.escalatoria.show', $escalatoria));
});

/**
 * Ordenes de Cambio de Insumos create
 */
Breadcrumbs::register('control_presupuesto.cambio_insumos.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVA CAMBIO DE INSUMOS', route('control_presupuesto.cambio_insumos.create'));
});

/**
 * Ordenes de Cambio de Insumos show
 */
Breadcrumbs::register('control_presupuesto.cambio_insumos.show', function ($breadcrumb, $cambio_insumos) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('#' . $cambio_insumos->numero_folio, route('control_presupuesto.escalatoria.show', $cambio_insumos));
});

/**
 * Ordenes de Cambio de Insumos Costo Indirecto create
 */
Breadcrumbs::register('control_presupuesto.cambio_insumos.costo_indirecto.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVA CAMBIO DE INSUMOS COSTO INDIRECTO', route('control_presupuesto.cambio_insumos.costo_indirecto.create'));
});

/**
 * Conceptos Extraordinarios Create
 */
Breadcrumbs::register('control_presupuesto.conceptos_extraordinarios.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.cambio_presupuesto.index');
    $breadcrumb->push('NUEVO CONCEPTO EXTRAORDINARIO', route('control_presupuesto.conceptos_extraordinarios.create'));
});

/**
 * Conceptos Extraordinarios Show
 */
Breadcrumbs::register('control_presupuesto.conceptos_extraordinarios.show', function ($breadcrumb, $cambio_insumos) {
    $breadcrumb->parent('control_presupuesto.conceptos_extraordinarios.index');
    $breadcrumb->push('#' . $cambio_insumos->numero_folio, route('control_presupuesto.escalatoria.show', $cambio_insumos));
});