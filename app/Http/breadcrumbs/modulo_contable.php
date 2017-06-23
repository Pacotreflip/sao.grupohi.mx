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
 * Tipo Cuenta Contable
 */

Breadcrumbs::register('modulo_contable.tipo_cuenta_contable.index', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('TIPO CUENTA CONTABLE', route('modulo_contable.tipo_cuenta_contable.index'));
});
Breadcrumbs::register('modulo_contable.tipo_cuenta_contable.create', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.tipo_cuenta_contable.index');
    $breadcrumb->push('NUEVA PLANTILLA PARA TIPO CUENTA CONTABLE', route('modulo_contable.tipo_cuenta_contable.create'));
});
Breadcrumbs::register('modulo_contable.tipo_cuenta_contable.show', function ($breadcrumb, $tipo_cuenta_contable) {
    $breadcrumb->parent('modulo_contable.tipo_cuenta_contable.index');
    $breadcrumb->push('VER TIPO CUENTA CONTABLE', route('modulo_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable));
});


/*
 * Cuenta Contable
 */
Breadcrumbs::register('modulo_contable.cuenta_contable.configuracion', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('CONFIGURACIÓN DE CUENTAS CONTABLES', route('modulo_contable.cuenta_contable.configuracion'));
});

/**
 * Poliza Generada
 */
Breadcrumbs::register('modulo_contable.poliza_generada.index', function ($breadcrumb) {
    $breadcrumb->parent('modulo_contable.index');
    $breadcrumb->push('PÓLIZAS GENERADAS', route('modulo_contable.poliza_generada.index'));
});
Breadcrumbs::register('modulo_contable.poliza_generada.show', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('modulo_contable.poliza_generada.index');
    $breadcrumb->push(strtoupper($poliza->tipoPolizaContpaq), route('modulo_contable.poliza_generada.show', $poliza));
});
Breadcrumbs::register('modulo_contable.poliza_generada.edit', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('modulo_contable.poliza_generada.show', $poliza);
    $breadcrumb->push('EDICIÓN', route('modulo_contable.poliza_generada.edit', $poliza));
});
Breadcrumbs::register('modulo_contable.poliza_generada.historico', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('modulo_contable.poliza_generada.index');
    $breadcrumb->push($poliza->tipoPolizaContpaq, route('modulo_contable.poliza_generada.historico', $poliza));
});