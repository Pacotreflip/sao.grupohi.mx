<?php

Breadcrumbs::register('configuracion.seguridad.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SEGURIDAD', route('configuracion.seguridad.index'));
});

Breadcrumbs::register('configuracion.presupuesto.index', function ($breadcrumb) {
   $breadcrumb->parent('index');
   $breadcrumb->push('CONFIGURACIÓN DEL PRESUPUESTO', route('configuracion.presupuesto.index'));
});