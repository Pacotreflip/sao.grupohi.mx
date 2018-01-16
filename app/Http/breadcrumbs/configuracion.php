<?php

Breadcrumbs::register('configuracion.seguridad.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SEGURIDAD', route('configuracion.seguridad.index'));
});