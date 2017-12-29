<?php

Breadcrumbs::register('control_costos.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('CONTROL DE COSTOS', route('control_costos.index'));
});

/**
 * Reclasificación de costos
 */
Breadcrumbs::register('control_costos.solicitudes_reclasificacion.index', function($breadcrumbs) {
    $breadcrumbs->parent('control_costos.index');
    $breadcrumbs->push('SOLICITUDES DE RECLASIFICACIÓN', route('control_costos.solicitudes_reclasificacion.index'));
});

/**
 * Solicitar reclasificación
 */
Breadcrumbs::register('control_costos.solicitar_reclasificacion.index', function($breadcrumbs) {
    $breadcrumbs->parent('control_costos.index');
    $breadcrumbs->push('SOLICITAR RECLASIFICACIÓN', route('control_costos.solicitar_reclasificacion.index'));
});

