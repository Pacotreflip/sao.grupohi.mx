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
    $breadcrumb->push('EDITAR', route('sistema_contable.tipo_cuenta_contable.edit', $tipo_cuenta_contable));
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
    $breadcrumb->push('EDITAR', route('sistema_contable.poliza_generada.edit', $poliza));
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
    $breadcrumb->push('EDITAR', route('sistema_contable.cuenta_empresa.edit', $empresa));
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

/**
 * Revaluaciones
 */
Breadcrumbs::register('sistema_contable.revaluacion.index', function($breadcrumbs) {
    $breadcrumbs->parent('sistema_contable.index');
    $breadcrumbs->push('REVALUACIONES', route('sistema_contable.revaluacion.index'));
});
Breadcrumbs::register('sistema_contable.revaluacion.create', function($breadcrumbs) {
    $breadcrumbs->parent('sistema_contable.revaluacion.index');
    $breadcrumbs->push('NUEVA', route('sistema_contable.revaluacion.create'));
});

Breadcrumbs::register('sistema_contable.revaluacion.show', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.revaluacion.index');
    $breadcrumb->push('VER REVALUACIÓN', route('sistema_contable.revaluacion.index'));
});

/**
 * Cuentas Fondos
 */
Breadcrumbs::register('sistema_contable.cuenta_fondo.index', function($breadcrumbs) {
    $breadcrumbs->parent('sistema_contable.index');
    $breadcrumbs->push('CUENTAS DE FONDOS', route('sistema_contable.cuenta_fondo.index'));
});

/**
 * Traspaso entre cuentas
 */
Breadcrumbs::register('sistema_contable.traspaso_cuentas.index', function($breadcrumbs) {
    $breadcrumbs->parent('sistema_contable.index');
    $breadcrumbs->push('TRASPASO ENTRE CUENTAS', route('sistema_contable.traspaso_cuentas.index'));
});

/**
 * Cuentas Contables Bancarias
 */
Breadcrumbs::register('sistema_contable.cuentas_contables_bancarias.index', function($breadcrumbs) {
    $breadcrumbs->parent('sistema_contable.index');
    $breadcrumbs->push('CUENTAS CONTABLES BANCARIAS', route('sistema_contable.cuentas_contables_bancarias.index'));
});

Breadcrumbs::register('sistema_contable.cuentas_contables_bancarias.show', function($breadcrumbs, $id_cuenta) {
    $breadcrumbs->parent('sistema_contable.cuentas_contables_bancarias.index');
    $breadcrumbs->push('CUENTA BANCARIA DETALLE', route('sistema_contable.cuentas_contables_bancarias.show', $id_cuenta));
});

Breadcrumbs::register('sistema_contable.cuentas_contables_bancarias.edit', function($breadcrumbs, $id_cuenta) {
    $breadcrumbs->parent('sistema_contable.cuentas_contables_bancarias.index');
    $breadcrumbs->push('EDITAR CUENTA BANCARIA', route('sistema_contable.cuentas_contables_bancarias.edit', $id_cuenta));
});

/**
 * Cuenta Costo
 */
Breadcrumbs::register('sistema_contable.cuenta_costo.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CUENTAS DE COSTOS', route('sistema_contable.cuenta_costo.index'));
});

/*
 * Cierre de Periodo Breadcrumbs...
 */
Breadcrumbs::register('sistema_contable.cierre.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('CIERRE DE PERIODO', route('sistema_contable.cierre.index'));
});

/**
 * Costos Dólares
 */
Breadcrumbs::register('sistema_contable.costos_dolares.index', function ($breadcrumb) {
    $breadcrumb->parent('sistema_contable.index');
    $breadcrumb->push('COSTOS MONEDA EXTRANJERA', route('sistema_contable.costos_dolares.index'));
});