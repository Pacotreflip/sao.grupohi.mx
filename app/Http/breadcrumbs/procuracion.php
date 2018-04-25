<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 19/04/2018
 * Time: 03:09 PM
 */


Breadcrumbs::register('procuracion.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('PROCURACIÓN', route('procuracion.index'));
});

/**
 * Asignación
 */
Breadcrumbs::register('procuracion.asignacion.index', function($breadcrumbs) {
    $breadcrumbs->parent('procuracion.index');
    $breadcrumbs->push('ASIGNACIÓN DE COMPRADORES', route('procuracion.asignacion.index'));
});
Breadcrumbs::register('procuracion.asignacion.create', function($breadcrumbs) {
    $breadcrumbs->parent('procuracion.asignacion.index');
    $breadcrumbs->push('REGISTRO DE ASIGNACIONES', route('procuracion.asignacion.create'));
});