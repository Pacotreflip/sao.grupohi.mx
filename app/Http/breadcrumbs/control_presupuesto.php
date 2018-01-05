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
    $breadcrumb->push('NUEVO', route('control_presupuesto.cambio_presupuesto.create'));
});
