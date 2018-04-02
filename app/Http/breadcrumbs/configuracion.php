<?php

Breadcrumbs::register('configuracion.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('CONFIGURACIÓN');
});

Breadcrumbs::register('configuracion.seguridad.index', function ($breadcrumb) {
    $breadcrumb->parent('configuracion.index');
    $breadcrumb->push('SEGURIDAD', route('configuracion.seguridad.index'));
});