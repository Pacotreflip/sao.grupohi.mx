<?php


Breadcrumbs::register('modulo_contable.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('MÓDULO CONTABLE', route('modulo_contable.index'));
});

/*
 * Poliza Tipo
 */
Breadcrumbs::register('modulo_contable.poliza_tipo.index', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('PÓLIZAS TIPO', route('modulo_contable.poliza_tipo.index'));
});
Breadcrumbs::register('modulo_contable.poliza_tipo.create', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.poliza_tipo.index');
    $breadcrumb->push('NUEVA PÓLIZA TIPO', route('modulo_contable.poliza_tipo.create'));
});
Breadcrumbs::register('modulo_contable.poliza_tipo.show', function ($breadcrumb, $poliza_tipo) {
    $breadcrumb->parent('modulo_contable.poliza_tipo.index');
    $breadcrumb->push($poliza_tipo->transaccionInterfaz, route('modulo_contable.poliza_tipo.show', $poliza_tipo));
});