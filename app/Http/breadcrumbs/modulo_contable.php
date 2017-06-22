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
    $breadcrumb->push('PLANTILLAS DE PÓLIZAS', route('modulo_contable.poliza_tipo.index'));
});
Breadcrumbs::register('modulo_contable.poliza_tipo.create', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.poliza_tipo.index');
    $breadcrumb->push('NUEVA PLANTILLA PARA PÓLIZA', route('modulo_contable.poliza_tipo.create'));
});
Breadcrumbs::register('modulo_contable.poliza_tipo.show', function ($breadcrumb, $poliza_tipo) {
    $breadcrumb->parent('modulo_contable.poliza_tipo.index');
    $breadcrumb->push($poliza_tipo->transaccion, route('modulo_contable.poliza_tipo.show', $poliza_tipo));
});

/*
 * Cuenta Contable
 */
Breadcrumbs::register('modulo_contable.cuenta_contable.configuracion', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('CONFIGURACIÓN DE CUENTAS CONTABLES', route('modulo_contable.cuenta_contable.configuracion'));
});
/**
 * Polizas Generales
 */
Breadcrumbs::register('modulo_contable.poliza_general.index', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('PÓLIZAS GENERALES', route('modulo_contable.poliza_general.index'));
});
Breadcrumbs::register('modulo_contable.poliza_general.show', function ($breadcrumb,$poliza) {
    $breadcrumb->parent('modulo_contable.poliza_general.index');
    $breadcrumb->push($poliza->tipoPolizaContpaq, route('modulo_contable.poliza_general.show',$poliza));
});