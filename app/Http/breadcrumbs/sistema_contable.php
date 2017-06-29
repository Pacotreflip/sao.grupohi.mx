<?php


Breadcrumbs::register('sistema_contable.index', function ($breadcrumb) {
    $breadcrumb->parent('index');
    $breadcrumb->push('SISTEMA CONTABLE', route('sistema_contable.index'));
});

/*
 * Poliza Tipo
 */
Breadcrumbs::register('sistema_contable.poliza_tipo.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('PLANTILLAS DE PÓLIZAS', route('sistema_contable.poliza_tipo.index'));
});
Breadcrumbs::register('sistema_contable.poliza_tipo.create', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.poliza_tipo.index');
    $breadcrumb->push('CREAR', route('sistema_contable.poliza_tipo.create'));
});
Breadcrumbs::register('sistema_contable.poliza_tipo.show', function ($breadcrumb, $poliza_tipo) {
    $breadcrumb->parent('sistema_contable.poliza_tipo.index');
    $breadcrumb->push(mb_strtoupper($poliza_tipo->transaccion), route('sistema_contable.poliza_tipo.show', $poliza_tipo));
});


/**
 * Tipo Cuenta Contable
 */

Breadcrumbs::register('sistema_contable.tipo_cuenta_contable.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('TIPOS DE CUENTAS CONTABLES', route('sistema_contable.tipo_cuenta_contable.index'));
});
Breadcrumbs::register('sistema_contable.tipo_cuenta_contable.create', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.tipo_cuenta_contable.index');
    $breadcrumb->push('CREAR', route('sistema_contable.tipo_cuenta_contable.create'));
});
Breadcrumbs::register('sistema_contable.tipo_cuenta_contable.show', function ($breadcrumb, $tipo_cuenta_contable) {
    $breadcrumb->parent('sistema_contable.tipo_cuenta_contable.index');
    $breadcrumb->push(mb_strtoupper($tipo_cuenta_contable->descripcion), route('sistema_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable));
});


/*
 * Cuenta Contable
 */
Breadcrumbs::register('sistema_contable.cuenta_contable.configuracion', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CONFIGURACIÓN DE CUENTAS CONTABLES', route('sistema_contable.cuenta_contable.configuracion'));
});

/**
 * Poliza Generada
 */
Breadcrumbs::register('sistema_contable.poliza_generada.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('PÓLIZAS GENERADAS', route('sistema_contable.poliza_generada.index'));
});
Breadcrumbs::register('sistema_contable.poliza_generada.show', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.index');
    $breadcrumb->push(mb_strtoupper($poliza->tipoPolizaContpaq), route('sistema_contable.poliza_generada.show', $poliza));
});
Breadcrumbs::register('sistema_contable.poliza_generada.edit', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.show', $poliza);
    $breadcrumb->push('EDICIÓN', route('sistema_contable.poliza_generada.edit', $poliza));
});
Breadcrumbs::register('sistema_contable.poliza_generada.historico', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.index');
    $breadcrumb->push(mb_strtoupper($poliza->tipoPolizaContpaq), route('sistema_contable.poliza_generada.historico', $poliza));
});

/**
 * Cuentas Material
 */

Breadcrumbs::register('sistema_contable.cuenta_material.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS MATERIALES', route('sistema_contable.cuenta_material.index'));
});
Breadcrumbs::register('sistema_contable.cuenta_material.create', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.cuenta_material.index');
    $breadcrumb->push('CREAR', route('sistema_contable.cuenta_material.create'));
});
Breadcrumbs::register('sistema_contable.cuenta_material.show', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.cuenta_material.index');
    $breadcrumb->push('VER CUENTAS DE MATERIALES', route('sistema_contable.cuenta_material.show'));
});
/**
 * Cuenta Concepto
 */
Breadcrumbs::register('sistema_contable.cuenta_concepto.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('RELACIÓN CONCEPTO - CUENTA', route('sistema_contable.cuenta_concepto.index'));
});

/**
 * Cuentas Almacenes
 */

Breadcrumbs::register('sistema_contable.cuenta_almacen.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE ALMACENES', route('sistema_contable.cuenta_almacen.index'));
});
