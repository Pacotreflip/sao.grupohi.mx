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
    $breadcrumb->push('PLANTILLAS DE PREPÓLIZAS', route('sistema_contable.poliza_tipo.index'));
});
Breadcrumbs::register('sistema_contable.poliza_tipo.create', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.poliza_tipo.index');
    $breadcrumb->push('CREAR', route('sistema_contable.poliza_tipo.create'));
});
Breadcrumbs::register('sistema_contable.poliza_tipo.show', function ($breadcrumb, $poliza_tipo) {
    $breadcrumb->parent('sistema_contable.poliza_tipo.index');
    $breadcrumb->push(mb_strtoupper($poliza_tipo->polizaTipoSAO), route('sistema_contable.poliza_tipo.show', $poliza_tipo));
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

Breadcrumbs::register('sistema_contable.tipo_cuenta_contable.edit', function ($breadcrumb, $tipo_cuenta_contable) {
    $breadcrumb->parent('sistema_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable);
    $breadcrumb->push('EDICIÓN', route('sistema_contable.tipo_cuenta_contable.edit', $tipo_cuenta_contable));
});
Breadcrumbs::register('sistema_contable.tipo_cuenta_contable.show', function ($breadcrumb, $tipo_cuenta_contable) {
    $breadcrumb->parent('sistema_contable.tipo_cuenta_contable.index');
    $breadcrumb->push(mb_strtoupper($tipo_cuenta_contable->descripcion), route('sistema_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable));
});


/*
 * Cuenta Contable
 */
Breadcrumbs::register('sistema_contable.cuenta_contable.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS GENERALES', route('sistema_contable.cuenta_contable.index'));
});

/**
 * Poliza Generada
 */
Breadcrumbs::register('sistema_contable.poliza_generada.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('PREPÓLIZAS GENERADAS', route('sistema_contable.poliza_generada.index'));
});
Breadcrumbs::register('sistema_contable.poliza_generada.show', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.index');
    $breadcrumb->push(mb_strtoupper($poliza->transaccionInterfaz), route('sistema_contable.poliza_generada.show', $poliza));
});
Breadcrumbs::register('sistema_contable.poliza_generada.edit', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.show', $poliza);
    $breadcrumb->push('EDICIÓN', route('sistema_contable.poliza_generada.edit', $poliza));
});
Breadcrumbs::register('sistema_contable.poliza_generada.historico', function ($breadcrumb, $poliza) {
    $breadcrumb->parent('sistema_contable.poliza_generada.index');
    $breadcrumb->push(mb_strtoupper($poliza->transaccionInterfaz), route('sistema_contable.poliza_generada.historico', $poliza));
});

/**
 * Cuenta Concepto
 */
Breadcrumbs::register('sistema_contable.cuenta_concepto.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE CONCEPTOS', route('sistema_contable.cuenta_concepto.index'));
});

/**
 * Cuentas Almacenes
 */

Breadcrumbs::register('sistema_contable.cuenta_almacen.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE ALMACENES', route('sistema_contable.cuenta_almacen.index'));
});
Breadcrumbs::register('sistema_contable.cuenta_almacen.show', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.cuenta_almacen.index');
    $breadcrumb->push('VER CUENTAS DE ALMACENES', route('sistema_contable.cuenta_almacen.index'));
});

/**
 * Cuentas Empresa
 */

Breadcrumbs::register('sistema_contable.cuenta_empresa.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE EMPRESAS', route('sistema_contable.cuenta_empresa.index'));
});
Breadcrumbs::register('sistema_contable.cuenta_empresa.show', function ($breadcrumb, $empresa) {
    $breadcrumb->parent('sistema_contable.cuenta_empresa.index');
    $breadcrumb->push(mb_strtoupper($empresa->razon_social), route('sistema_contable.cuenta_empresa.show', $empresa));
});

Breadcrumbs::register('sistema_contable.cuenta_empresa.edit', function ($breadcrumb, $empresa) {
    $breadcrumb->parent('sistema_contable.cuenta_empresa.show', $empresa);
    $breadcrumb->push('EDICIÓN', route('sistema_contable.cuenta_empresa.edit', $empresa));
});


/**
 * Datos Contables
 */
Breadcrumbs::register('sistema_contable.datos_contables.edit', function ($breadcrumb, $datos_contables) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push($datos_contables->obra->nombre, route('sistema_contable.datos_contables.edit', $datos_contables));
});


/**
 * Kardex Materiales
 */

Breadcrumbs::register('sistema_contable.kardex_material.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('KARDEX DE MATERIALES', route('sistema_contable.kardex_material.index'));
});

/**
 *  Cuentas Materiales
 */
Breadcrumbs::register('sistema_contable.cuenta_material.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE MATERIALES', route('sistema_contable.cuenta_material.index'));
});
Breadcrumbs::register('sistema_contable.cuenta_material.show', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.cuenta_material.index');
    $breadcrumb->push('VER CUENTAS DE ALMACENES', route('sistema_contable.cuenta_material.index'));
});
