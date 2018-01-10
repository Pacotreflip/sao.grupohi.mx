<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Seguridad\Permission;
use Ghi\Domain\Core\Models\Seguridad\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permisos
         */

        // Cuentas de Almacén
        $editar_cuenta_almacen    = Permission::create(['name' => 'editar_cuenta_almacen', 'display_name' => 'Editar Cuenta de Almacén', 'description' => 'Permiso para editar una cuenta contable registrada en un Almacén']);
        $registrar_cuenta_almacen = Permission::create(['name' => 'registrar_cuenta_almacen', 'display_name' => 'Registrar Cuenta de Almacén', 'description' => 'Permiso para registrar una cuenta contable en un Almacén']);
        $consultar_cuenta_almacen = Permission::create(['name' => 'consultar_cuenta_almacen', 'display_name' => 'Consultar Cuenta de Almacén', 'description' => 'Permiso para consultar una o varias cuentas contables de Almacén']);

        //Cuentas de Conceptos
        $editar_cuenta_concepto    = Permission::create(['name' => 'editar_cuenta_concepto', 'display_name' => 'Editar Cuenta de Concepto', 'description' => 'Permiso para editar una cuenta contable registrada en un Concepto']);
        $registrar_cuenta_concepto = Permission::create(['name' => 'registrar_cuenta_concepto', 'display_name' => 'Registrar Cuenta de Concepto', 'description' => 'Permiso para registrar una cuenta contable en un Concepto']);
        $consultar_cuenta_concepto = Permission::create(['name' => 'consultar_cuenta_concepto', 'display_name' => 'Consultar Cuenta de Concepto', 'description' => 'Permiso para consultar una o varias cuentas contables de Concepto']);

        // Cuentas Empresas
        $editar_cuenta_empresa    = Permission::create(['name' => 'editar_cuenta_empresa', 'display_name' => 'Editar Cuenta de Empresa', 'description' => 'Permiso para editar una cuenta contable registrada en una Empresa']);
        $registrar_cuenta_empresa = Permission::create(['name' => 'registrar_cuenta_empresa', 'display_name' => 'Registrar Cuenta de Empresa', 'description' => 'Permiso para registrar una cuenta contable en una Empresa']);
        $consultar_cuenta_empresa = Permission::create(['name' => 'consultar_cuenta_empresa', 'display_name' => 'Consultar Cuenta de Empresa', 'description' => 'Permiso para consultar una o varias cuentas contables de Empresa']);
        $eliminar_cuenta_empresa  = Permission::create(['name' => 'eliminar_cuenta_empresa', 'display_name' => 'Eliminar Cuenta de Empresa', 'description' => 'Permiso para eliminar cuentas contables de Empresa']);

        // Cuentas Generales
        $consultar_cuenta_general = Permission::create(['name' => 'consultar_cuenta_general', 'display_name' => 'Consultar Cuenta General', 'description' => 'Permiso para consultar una o varias Cuentas Contables Generales']);
        $registrar_cuenta_general = Permission::create(['name' => 'registrar_cuenta_general', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable General']);
        $editar_cuenta_general    = Permission::create(['name' => 'editar_cuenta_general', 'display_name' => 'Editar Cuenta General', 'description' => 'Permiso para editar una cuenta contable General']);

        // Cuentas Materiales
        $consultar_cuenta_material = Permission::create(['name' => 'consultar_cuenta_material', 'display_name' => 'Consultar Cuenta de Material', 'description' => 'Permiso para consultar una o varias cuentas contables de materiales']);
        $registrar_cuenta_material = Permission::create(['name' => 'registrar_cuenta_material', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable en un Material']);
        $editar_cuenta_material    = Permission::create(['name' => 'editar_cuenta_material', 'display_name' => 'Editar Cuenta Metarial', 'description' => 'Permiso para editar una cuenta contable registrada en un Material']);

        // Tipo Cuenta Contable
        $consultar_tipo_cuenta_contable = Permission::create(['name' => 'consultar_tipo_cuenta_contable', 'display_name' => 'Consultar Tipo de Cuenta Contable', 'description' => 'Permiso para consultar uno o varios tipos de cuenta contable']);
        $registrar_tipo_cuenta_contable = Permission::create(['name' => 'registrar_tipo_cuenta_contable', 'display_name' => 'Registrar Tipo de Cuenta Contable', 'description' => 'Permiso para registrar un tipo de cuenta contable']);
        $editar_tipo_cuenta_contable    = Permission::create(['name' => 'editar_tipo_cuenta_contable', 'display_name' => 'Editar Tipo de Cuenta Contable', 'description' => 'Permiso para editar un tipo de cuenta contable']);
        $eliminar_tipo_cuenta_contable  = Permission::create(['name' => 'eliminar_tipo_cuenta_contable', 'display_name' => 'Eliminar Tipo de Cuenta Contable', 'description' => 'Permiso para eliminar un tipo de cuenta contable']);

        // Plantillas de Prepólizas
        $consultar_plantilla_prepoliza = Permission::create(['name' => 'consultar_plantilla_prepoliza', 'display_name' => 'Consultar Plantilla de Prepóliza', 'description' => 'Permiso para consultar una o varias plantillas de Prepólizas']);
        $registrar_plantilla_prepoliza = Permission::create(['name' => 'registrar_plantilla_prepoliza', 'display_name' => 'Registrar Plantilla de Prepóliza', 'description' => 'Permiso para registrar  plantillas de Prepólizas']);
        $eliminar_plantilla_prepoliza  = Permission::create(['name' => 'eliminar_plantilla_prepoliza', 'display_name' => 'Eliminar Plantilla de Prepóliza', 'description' => 'Permiso para eliminar plantillas de Prepólizas']);

        // Configuración contable
        $editar_configuracion_contable = Permission::create(['name' => 'editar_configuracion_contable', 'display_name' => 'Editar Configuración Contable', 'description' => 'Permiso para editar la configuración Contable de la obra en contexto']);

        // Prepólizas Generadas
        $consultar_prepolizas_generadas = Permission::create(['name' => 'consultar_prepolizas_generadas', 'display_name' => 'Consultar Prepólizas Generadas', 'description' => 'Permiso para consultar una o varias Prepólizas Generadas']);
        $editar_prepolizas_generadas    = Permission::create(['name' => 'editar_prepolizas_generadas', 'display_name' => 'Editar Prepólizas Generadas', 'description' => 'Permiso para editar las Prepólizas Generadas']);

        // Kardex Material
        $consultar_kardex_material = Permission::create(['name' => 'consultar_kardex_material', 'display_name' => 'Consultar Kardex de Materiales', 'description' => 'Permiso para consultar el Kardex de Materiales']);

        //Solicitud de Recasificación
        $solicitar_reclasificacion = Permission::create(['name' => 'solicitar_reclasificacion', 'display_name' => 'Solicitar Reclasificación', 'description' => 'Permiso para Solicitar Reclasificación de Costo']);
        $autorizar_reclasificacion = Permission::create(['name' => 'autorizar_reclasificacion', 'display_name' => 'Autorizar Reclasificación', 'description' => 'Permiso para Autorizar Reclasificación de Costo']);
        $consultar_reclasificacion = Permission::create(['name' => 'consultar_reclasificacion', 'display_name' => 'Consultar Reclasificación', 'description' => 'Permiso para Consultar Reclasificación de Costo']);

        //Formato de Orden de Pago Estimación
        $consultar_reporte_estimacion = Permission::create(['name' => 'consultar_reporte_estimacion', 'description' => 'Consultar Solicitudes de Orden de Pago Estimación', 'display_name' => 'Consultar Solicitudes de Orden de Pago Estimación']);

        //Comprobante de Fondo Fijo
        $editar_comprobante_fondo_fijo    = Permission::create(['name' => 'editar_comprobante_fondo_fijo', 'display_name' => 'Editar Comprobante de Fondo Fijo', 'description' => 'Permiso para editar un Comprobante de Fondo Fijo']);
        $registrar_comprobante_fondo_fijo = Permission::create(['name' => 'registrar_comprobante_fondo_fijo', 'display_name' => 'Registrar Comprobante de Fondo Fijo', 'description' => 'Permiso para registrar un Comprobante de Fondo Fijo']);
        $consultar_comprobante_fondo_fijo = Permission::create(['name' => 'consultar_comprobante_fondo_fijo', 'display_name' => 'Consultar Comprobante de Fondo Fijo', 'description' => 'Permiso para consultar un Comprobante de Fondo Fijo']);
        $eliminar_comprobante_fondo_fijo  = Permission::create(['name' => 'eliminar_comprobante_fondo_fijo', 'display_name' => 'Eliminar Comprobante de Fondo Fijo', 'description' => 'Permiso para eliminar un Comprobante de Fondo Fijo']);

        //Traspaso Entre Cuentas
        $eliminar_traspaso_cuenta  = Permission::create(['name' => 'eliminar_traspaso_cuenta', 'display_name' => 'Eliminar Traspasos entre cuentas', 'description' => 'Permiso para eliminar traspasos entre cuentas']);
        $registrar_traspaso_cuenta = Permission::create(['name' => 'registrar_traspaso_cuenta', 'display_name' => 'Registrar Traspasos entre cuentas', 'description' => 'Permiso para registrar un traspaso entre cuentas']);
        $consultar_traspaso_cuenta = Permission::create(['name' => 'consultar_traspaso_cuenta', 'display_name' => 'Consultar Traspasos entre cuentas', 'description' => 'Permiso para consultar la lista de traspasos entre cuentas']);
        $editar_traspaso_cuenta    = Permission::create(['name' => 'editar_traspaso_cuenta', 'display_name' => 'Editar Traspasos entre cuentas', 'description' => 'Permiso para editar la lista de traspasos entre cuentas']);

        //Movimientos Bancarios
        $eliminar_movimiento_bancario  = Permission::create(['name' => 'eliminar_movimiento_bancario', 'display_name' => 'Eliminar Movimientos Bancarios', 'description' => 'Permiso para eliminar Movimientos Bancarios']);
        $registrar_movimiento_bancario = Permission::create(['name' => 'registrar_movimiento_bancario', 'display_name' => 'Registrar Movimientos Bancarios', 'description' => 'Permiso para registrar un movimiento bancario']);
        $consultar_movimiento_bancario = Permission::create(['name' => 'consultar_movimiento_bancario', 'display_name' => 'Consultar Movimientos Bancarios', 'description' => 'Permiso para consultar la lista de Movimientos Bancarios']);
        $editar_movimiento_bancario    = Permission::create(['name' => 'editar_movimiento_bancario', 'display_name' => 'Editar Movimientos Bancarios', 'description' => 'Permiso para editar la lista de Movimientos Bancarios']);


        //Cuentas de Fondo
        $editar_cuenta_fondo    = Permission::create(['name' => 'editar_cuenta_fondo', 'display_name' => 'Editar Cuenta de Fondo', 'description' => 'Permiso para editar una cuenta contable registrada en un Fondo']);
        $registrar_cuenta_fondo = Permission::create(['name' => 'registrar_cuenta_fondo', 'display_name' => 'Registrar Cuenta de Fondo', 'description' => 'Permiso para registrar una cuenta contable en un Fondo']);
        $consultar_cuenta_fondo = Permission::create(['name' => 'consultar_cuenta_fondo', 'display_name' => 'Consultar Cuenta de Fondo', 'description' => 'Permiso para consultar una o varias cuentas contables de Fondo']);

        //PermisosCuentasContablesBancarias
        $eliminar_cuenta_contable_bancaria  = Permission::create(['name' => 'eliminar_cuenta_contable_bancaria', 'display_name' => 'Eliminar Cuenta Contable Bancaria', 'description' => 'Permiso para eliminar cuentas contables bancarias']);
        $registrar_cuenta_contable_bancaria = Permission::create(['name' => 'registrar_cuenta_contable_bancaria', 'display_name' => 'Registrar Cuenta Contable Bancaria', 'description' => 'Permiso para registrar cuentas contables bancarias']);
        $consultar_cuenta_contable_bancaria = Permission::create(['name' => 'consultar_cuenta_contable_bancaria', 'display_name' => 'Consultar Cuenta Contable Bancaria', 'description' => 'Permiso para consultar cuentas contables bancarias']);
        $editar_cuenta_contable_bancaria    = Permission::create(['name' => 'editar_cuenta_contable_bancaria', 'display_name' => 'Editar Cuenta Contable Bancaria', 'description' => 'Permiso para editar cuentas contables bancarias']);


        //PermisosCuentasCosto
        $eliminar_cuenta_costo  = Permission::create(['name' => 'eliminar_cuenta_costo', 'display_name' => 'Eliminar Cuenta de Costo', 'description' => 'Permiso para eliminar cuenta de costo']);
        $registrar_cuenta_costo = Permission::create(['name' => 'registrar_cuenta_costo', 'display_name' => 'Registrar Cuenta de Costo', 'description' => 'Permiso para registrar una cuenta de costo']);
        $consultar_cuenta_costo = Permission::create(['name' => 'consultar_cuenta_costo', 'display_name' => 'Consultar Cuenta de Costo', 'description' => 'Permiso para consultar la lista de cuentas de costos']);
        $editar_cuenta_costo    = Permission::create(['name' => 'editar_cuenta_costo', 'display_name' => 'Editar Cuenta de Costo', 'description' => 'Permiso para editar cuentas de Costos']);

        //Cierres de Periodo
        $consultar_cierre_periodo = Permission::create(['name' => 'consultar_cierre_periodo', 'display_name' => 'Cierre de Periodo', 'descriptio' => 'Cierre de Periodo']);
        $generar_cierre_periodo = Permission::create(['name' => 'generar_cierre_periodo', 'display_name' => 'Cierre de Periodo', 'descriptio' => 'Cierre de Periodo']);
        $editar_cierre_periodo = Permission::create(['name' => 'editar_cierre_periodo', 'display_name' => 'Cierre de Periodo', 'descriptio' => 'Cierre de Periodo']);

        /**
         * Roles
         */
        $contador          = Role::create(['name' => 'contador', 'display_name' => 'Contador', 'description' => 'Rol de Contador']);
        $consultar         = Role::create(['name' => 'consultar', 'display_name' => 'Consultar', 'description' => 'Rol para consultar']);
        $control_proyecto  = Role::create(['name' => 'control_proyecto', 'display_name' => 'Control de Proyecto', 'description' => 'Rol de usuario de Control de Proyecto']);
        $jefe_subcontratos = Role::create(['name' => 'jefe_subcontratos', 'description' => 'Jefe de Subcontratos', 'display_name' => 'Jefe de Subcontratos']);
        $jefe_procuracion  = Role::create(['name' => 'jefe_procuracion', 'description' => 'Jefe de Procuración', 'display_name' => 'Jefe de Procuración']);
        $tesorero          = Role::create(['name' => 'tesorero', 'display_name' => 'Tesorero', 'description' => 'Rol para operar el sistema de finanzas']);
        $consulta_finanzas = Role::create(['name' => 'consulta_finanzas', 'display_name' => 'Consulta Finanzas', 'description' => 'Rol para consultar el sistema de finanzas']);

        /**
         * Asignaciones
         */
        $control_proyecto->attachPermissions([$solicitar_reclasificacion, $autorizar_reclasificacion, $consultar_reclasificacion]);
        $jefe_procuracion->attachPermission($consultar_reporte_estimacion);
        $jefe_subcontratos->attachPermission($consultar_reporte_estimacion);
        $contador->attachPermissions([$editar_cuenta_fondo, $registrar_cuenta_fondo, $consultar_cuenta_fondo]);
        $consultar->attachPermission($consultar_cuenta_fondo);
        $contador->attachPermissions([$editar_cuenta_costo, $registrar_cuenta_costo, $consultar_cuenta_costo, $eliminar_cuenta_costo]);
        $tesorero->attachPermissions([$editar_comprobante_fondo_fijo, $registrar_comprobante_fondo_fijo, $consultar_comprobante_fondo_fijo,$eliminar_comprobante_fondo_fijo]);
        $consulta_finanzas->attachPermission($consultar_comprobante_fondo_fijo);
        $contador->attachPermissions([$consultar_cierre_periodo, $generar_cierre_periodo, $editar_cierre_periodo]);
        $control_proyecto->attachPermission($consultar_cierre_periodo);
    }
}
