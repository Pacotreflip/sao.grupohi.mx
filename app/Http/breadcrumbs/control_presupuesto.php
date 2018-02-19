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
    $breadcrumb->push(mb_strtoupper($solicitud->tipoOrden->descripcion), route('control_presupuesto.cambio_presupuesto.show', $solicitud));
});

/**
 * Variación de Volúmen
 */
Breadcrumbs::register('control_presupuesto.variacion_volumen.index', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.index');
    $breadcrumb->push('VARIACIÓN DE VOLÚMEN (ADITIVAS Y DEDUCTIVAS)', route('control_presupuesto.variacion_volumen.index'));
});

Breadcrumbs::register('control_presupuesto.variacion_volumen.create', function ($breadcrumb) {
    $breadcrumb->parent('control_presupuesto.variacion_volumen.index');
    $breadcrumb->push('NUEVA', route('control_presupuesto.variacion_volumen.create'));
});