require('./vue-components/global-errors');
require('./vue-components/errors');
require('./vue-components/select2');

/**
 *
 */
require('./vue-components/page/index');

/**
 *
 */
require('./vue-components/SistemaContable/poliza_tipo/index');
/**
 * Contabilidad Components...
 */
require('./vue-components/Contabilidad/emails');

require('./vue-components/Contabilidad/poliza_tipo/poliza-tipo-create');
require('./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-create');
require('./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-update');
require('./vue-components/Contabilidad/cuenta_contable/index');
require('./vue-components/Contabilidad/poliza_generada/edit');
require('./vue-components/Contabilidad/poliza_generada/index');
require('./vue-components/Contabilidad/cuenta_concepto/index');
require('./vue-components/Contabilidad/cuenta_material/index');
require('./vue-components/Contabilidad/cuenta_empresa/cuenta-empresa-edit');
require('./vue-components/Contabilidad/cuenta_almacen/index');
require('./vue-components/Contabilidad/datos_contables/edit');
require('./vue-components/kardex_material/kardex-material-index');
require('./vue-components/Contabilidad/modulos/revaluacion/create');
require('./vue-components/Contabilidad/cuenta_fondo/index');
require('./vue-components/Contabilidad/cuenta_bancos/cuenta-bancaria-edit');
require('./vue-components/Contabilidad/cuenta_costo/index');
require('./vue-components/Contabilidad/cierre/index');


/**
 * Compras Components
 */
require('./vue-components/Compras/requisicion/create');
require('./vue-components/Compras/requisicion/edit');
require('./vue-components/Compras/material/index');

/**
 * Finanzas Components
 */
require('./vue-components/Finanzas/comprobante_fondo_fijo/index');
require('./vue-components/Finanzas/comprobante_fondo_fijo/create');
require('./vue-components/Finanzas/comprobante_fondo_fijo/edit');

require('./vue-components/Finanzas/solicitud_cheque/reposicion_fondo_fijo/create')
require('./vue-components/Finanzas/solicitud_cheque/pago_cuenta/create')

/**
 * Formatos Components
 */
require('./vue-components/Formatos/subcontratos-estimacion');
require('./vue-components/Formatos/subcontratos-comparativa-presupuestos');

/**
 * Tesoreria Components
 */
require('./vue-components/Tesoreria/traspaso_cuentas/index');
require('./vue-components/Tesoreria/movimientos_bancarios/index');

/**
 * Control de costos Components
 */
require('./vue-components/ControlCostos/solicitar_reclasificacion/index');
require('./vue-components/ControlCostos/solicitar_reclasificacion/items');
require('./vue-components/ControlCostos/reclasificacion_costos/index');

/**
 * Control de Presupuesto Components
 */
require('./vue-components/ControlPresupuesto/index');
require('./vue-components/ControlPresupuesto/cambio_presupuesto/create');
require('./vue-components/ControlPresupuesto/cambio_presupuesto/index');

//require('./vue-components/ControlPresupuesto/cambio_presupuesto/variacion_insumos');
//require('./vue-components/ControlPresupuesto/cambio_presupuesto/show/variacion_insumos');

/**
 * Variacion de Volúmen Components
 */
require('./vue-components/ControlPresupuesto/variacion_volumen/create');
require('./vue-components/ControlPresupuesto/variacion_volumen/show');

/**
 * Escalatoria Components
 */
require('./vue-components/ControlPresupuesto/escalatoria/show');
require('./vue-components/ControlPresupuesto/escalatoria/create');

/**
 * Cambio Insumos Components
 */
require('./vue-components/ControlPresupuesto/cambio_insumos/show');
require('./vue-components/ControlPresupuesto/cambio_insumos/create');
require('./vue-components/ControlPresupuesto/cambio_insumos/costo_indirecto/create');

/**
 * Configuración Components
 */
require('./vue-components/Configuracion/seguridad/index');
require('./vue-components/Configuracion/presupuesto/index');
require('./vue-components/Configuracion/obra/index');


/**
 * Cambio Cantidad Insumos Components
 */
require('./vue-components/ControlPresupuesto/cambio_cantidad_insumos/create');
require('./vue-components/ControlPresupuesto/cambio_cantidad_insumos/show');

/**
 * Procuración
 */
require('./vue-components/Procuracion/asignacion/index');
require('./vue-components/Procuracion/asignacion/create');