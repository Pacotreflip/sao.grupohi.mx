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