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
        $editar_cuenta_almacen    = Permission::firstOrCreate(['name' => 'editar_cuenta_almacen', 'display_name' => 'Editar Cuenta de Almacén', 'description' => 'Permiso para editar una cuenta contable registrada en un Almacén']);
        $registrar_cuenta_almacen = Permission::firstOrCreate(['name' => 'registrar_cuenta_almacen', 'display_name' => 'Registrar Cuenta de Almacén', 'description' => 'Permiso para registrar una cuenta contable en un Almacén']);
        $consultar_cuenta_almacen = Permission::firstOrCreate(['name' => 'consultar_cuenta_almacen', 'display_name' => 'Consultar Cuenta de Almacén', 'description' => 'Permiso para consultar una o varias cuentas contables de Almacén']);

        //Cuentas de Conceptos
        $editar_cuenta_concepto    = Permission::firstOrCreate(['name' => 'editar_cuenta_concepto', 'display_name' => 'Editar Cuenta de Concepto', 'description' => 'Permiso para editar una cuenta contable registrada en un Concepto']);
        $registrar_cuenta_concepto = Permission::firstOrCreate(['name' => 'registrar_cuenta_concepto', 'display_name' => 'Registrar Cuenta de Concepto', 'description' => 'Permiso para registrar una cuenta contable en un Concepto']);
        $consultar_cuenta_concepto = Permission::firstOrCreate(['name' => 'consultar_cuenta_concepto', 'display_name' => 'Consultar Cuenta de Concepto', 'description' => 'Permiso para consultar una o varias cuentas contables de Concepto']);

        // Cuentas Empresas
        $editar_cuenta_empresa    = Permission::firstOrCreate(['name' => 'editar_cuenta_empresa', 'display_name' => 'Editar Cuenta de Empresa', 'description' => 'Permiso para editar una cuenta contable registrada en una Empresa']);
        $registrar_cuenta_empresa = Permission::firstOrCreate(['name' => 'registrar_cuenta_empresa', 'display_name' => 'Registrar Cuenta de Empresa', 'description' => 'Permiso para registrar una cuenta contable en una Empresa']);
        $consultar_cuenta_empresa = Permission::firstOrCreate(['name' => 'consultar_cuenta_empresa', 'display_name' => 'Consultar Cuenta de Empresa', 'description' => 'Permiso para consultar una o varias cuentas contables de Empresa']);
        $eliminar_cuenta_empresa  = Permission::firstOrCreate(['name' => 'eliminar_cuenta_empresa', 'display_name' => 'Eliminar Cuenta de Empresa', 'description' => 'Permiso para eliminar cuentas contables de Empresa']);

        // Cuentas Generales
        $consultar_cuenta_general = Permission::firstOrCreate(['name' => 'consultar_cuenta_general', 'display_name' => 'Consultar Cuenta General', 'description' => 'Permiso para consultar una o varias Cuentas Contables Generales']);
        $registrar_cuenta_general = Permission::firstOrCreate(['name' => 'registrar_cuenta_general', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable General']);
        $editar_cuenta_general    = Permission::firstOrCreate(['name' => 'editar_cuenta_general', 'display_name' => 'Editar Cuenta General', 'description' => 'Permiso para editar una cuenta contable General']);

        // Cuentas Materiales
        $consultar_cuenta_material = Permission::firstOrCreate(['name' => 'consultar_cuenta_material', 'display_name' => 'Consultar Cuenta de Material', 'description' => 'Permiso para consultar una o varias cuentas contables de materiales']);
        $registrar_cuenta_material = Permission::firstOrCreate(['name' => 'registrar_cuenta_material', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable en un Material']);
        $editar_cuenta_material    = Permission::firstOrCreate(['name' => 'editar_cuenta_material', 'display_name' => 'Editar Cuenta Metarial', 'description' => 'Permiso para editar una cuenta contable registrada en un Material']);

        // Tipo Cuenta Contable
        $consultar_tipo_cuenta_contable = Permission::firstOrCreate(['name' => 'consultar_tipo_cuenta_contable', 'display_name' => 'Consultar Tipo de Cuenta Contable', 'description' => 'Permiso para consultar uno o varios tipos de cuenta contable']);
        $registrar_tipo_cuenta_contable = Permission::firstOrCreate(['name' => 'registrar_tipo_cuenta_contable', 'display_name' => 'Registrar Tipo de Cuenta Contable', 'description' => 'Permiso para registrar un tipo de cuenta contable']);
        $editar_tipo_cuenta_contable    = Permission::firstOrCreate(['name' => 'editar_tipo_cuenta_contable', 'display_name' => 'Editar Tipo de Cuenta Contable', 'description' => 'Permiso para editar un tipo de cuenta contable']);
        $eliminar_tipo_cuenta_contable  = Permission::firstOrCreate(['name' => 'eliminar_tipo_cuenta_contable', 'display_name' => 'Eliminar Tipo de Cuenta Contable', 'description' => 'Permiso para eliminar un tipo de cuenta contable']);

        // Plantillas de Prepólizas
        $consultar_plantilla_prepoliza = Permission::firstOrCreate(['name' => 'consultar_plantilla_prepoliza', 'display_name' => 'Consultar Plantilla de Prepóliza', 'description' => 'Permiso para consultar una o varias plantillas de Prepólizas']);
        $registrar_plantilla_prepoliza = Permission::firstOrCreate(['name' => 'registrar_plantilla_prepoliza', 'display_name' => 'Registrar Plantilla de Prepóliza', 'description' => 'Permiso para registrar  plantillas de Prepólizas']);
        $eliminar_plantilla_prepoliza  = Permission::firstOrCreate(['name' => 'eliminar_plantilla_prepoliza', 'display_name' => 'Eliminar Plantilla de Prepóliza', 'description' => 'Permiso para eliminar plantillas de Prepólizas']);

        // Configuración contable
        $editar_configuracion_contable = Permission::firstOrCreate(['name' => 'editar_configuracion_contable', 'display_name' => 'Editar Configuración Contable', 'description' => 'Permiso para editar la configuración Contable de la obra en contexto']);

        // Prepólizas Generadas
        $consultar_prepolizas_generadas = Permission::firstOrCreate(['name' => 'consultar_prepolizas_generadas', 'display_name' => 'Consultar Prepólizas Generadas', 'description' => 'Permiso para consultar una o varias Prepólizas Generadas']);
        $editar_prepolizas_generadas    = Permission::firstOrCreate(['name' => 'editar_prepolizas_generadas', 'display_name' => 'Editar Prepólizas Generadas', 'description' => 'Permiso para editar las Prepólizas Generadas']);

        // Kardex Material
        $consultar_kardex_material = Permission::firstOrCreate(['name' => 'consultar_kardex_material', 'display_name' => 'Consultar Kardex de Materiales', 'description' => 'Permiso para consultar el Kardex de Materiales']);

        //Solicitud de Recasificación
        $solicitar_reclasificacion = Permission::firstOrCreate(['name' => 'solicitar_reclasificacion', 'display_name' => 'Solicitar Reclasificación', 'description' => 'Permiso para Solicitar Reclasificación de Costo']);
        $autorizar_reclasificacion = Permission::firstOrCreate(['name' => 'autorizar_reclasificacion', 'display_name' => 'Autorizar Reclasificación', 'description' => 'Permiso para Autorizar Reclasificación de Costo']);
        $consultar_reclasificacion = Permission::firstOrCreate(['name' => 'consultar_reclasificacion', 'display_name' => 'Consultar Reclasificación', 'description' => 'Permiso para Consultar Reclasificación de Costo']);

        //Formato de Orden de Pago Estimación
        $consultar_reporte_estimacion = Permission::firstOrCreate(['name' => 'consultar_reporte_estimacion', 'description' => 'Consultar Reporte de Orden de Pago Estimación', 'display_name' => 'Consultar Reporte de Orden de Pago Estimación']);

        //Comprobante de Fondo Fijo
        $editar_comprobante_fondo_fijo    = Permission::firstOrCreate(['name' => 'editar_comprobante_fondo_fijo', 'display_name' => 'Editar Comprobante de Fondo Fijo', 'description' => 'Permiso para editar un Comprobante de Fondo Fijo']);
        $registrar_comprobante_fondo_fijo = Permission::firstOrCreate(['name' => 'registrar_comprobante_fondo_fijo', 'display_name' => 'Registrar Comprobante de Fondo Fijo', 'description' => 'Permiso para registrar un Comprobante de Fondo Fijo']);
        $consultar_comprobante_fondo_fijo = Permission::firstOrCreate(['name' => 'consultar_comprobante_fondo_fijo', 'display_name' => 'Consultar Comprobante de Fondo Fijo', 'description' => 'Permiso para consultar un Comprobante de Fondo Fijo']);
        $eliminar_comprobante_fondo_fijo  = Permission::firstOrCreate(['name' => 'eliminar_comprobante_fondo_fijo', 'display_name' => 'Eliminar Comprobante de Fondo Fijo', 'description' => 'Permiso para eliminar un Comprobante de Fondo Fijo']);

        //Traspaso Entre Cuentas
        $eliminar_traspaso_cuenta  = Permission::firstOrCreate(['name' => 'eliminar_traspaso_cuenta', 'display_name' => 'Eliminar Traspasos entre cuentas', 'description' => 'Permiso para eliminar traspasos entre cuentas']);
        $registrar_traspaso_cuenta = Permission::firstOrCreate(['name' => 'registrar_traspaso_cuenta', 'display_name' => 'Registrar Traspasos entre cuentas', 'description' => 'Permiso para registrar un traspaso entre cuentas']);
        $consultar_traspaso_cuenta = Permission::firstOrCreate(['name' => 'consultar_traspaso_cuenta', 'display_name' => 'Consultar Traspasos entre cuentas', 'description' => 'Permiso para consultar la lista de traspasos entre cuentas']);
        $editar_traspaso_cuenta    = Permission::firstOrCreate(['name' => 'editar_traspaso_cuenta', 'display_name' => 'Editar Traspasos entre cuentas', 'description' => 'Permiso para editar la lista de traspasos entre cuentas']);

        //Movimientos Bancarios
        $eliminar_movimiento_bancario  = Permission::firstOrCreate(['name' => 'eliminar_movimiento_bancario', 'display_name' => 'Eliminar Movimientos Bancarios', 'description' => 'Permiso para eliminar Movimientos Bancarios']);
        $registrar_movimiento_bancario = Permission::firstOrCreate(['name' => 'registrar_movimiento_bancario', 'display_name' => 'Registrar Movimientos Bancarios', 'description' => 'Permiso para registrar un movimiento bancario']);
        $consultar_movimiento_bancario = Permission::firstOrCreate(['name' => 'consultar_movimiento_bancario', 'display_name' => 'Consultar Movimientos Bancarios', 'description' => 'Permiso para consultar la lista de Movimientos Bancarios']);
        $editar_movimiento_bancario    = Permission::firstOrCreate(['name' => 'editar_movimiento_bancario', 'display_name' => 'Editar Movimientos Bancarios', 'description' => 'Permiso para editar la lista de Movimientos Bancarios']);


        //Cuentas de Fondo
        $editar_cuenta_fondo    = Permission::firstOrCreate(['name' => 'editar_cuenta_fondo', 'display_name' => 'Editar Cuenta de Fondo', 'description' => 'Permiso para editar una cuenta contable registrada en un Fondo']);
        $registrar_cuenta_fondo = Permission::firstOrCreate(['name' => 'registrar_cuenta_fondo', 'display_name' => 'Registrar Cuenta de Fondo', 'description' => 'Permiso para registrar una cuenta contable en un Fondo']);
        $consultar_cuenta_fondo = Permission::firstOrCreate(['name' => 'consultar_cuenta_fondo', 'display_name' => 'Consultar Cuenta de Fondo', 'description' => 'Permiso para consultar una o varias cuentas contables de Fondo']);

        //PermisosCuentasContablesBancarias
        $eliminar_cuenta_contable_bancaria  = Permission::firstOrCreate(['name' => 'eliminar_cuenta_contable_bancaria', 'display_name' => 'Eliminar Cuenta Contable Bancaria', 'description' => 'Permiso para eliminar cuentas contables bancarias']);
        $registrar_cuenta_contable_bancaria = Permission::firstOrCreate(['name' => 'registrar_cuenta_contable_bancaria', 'display_name' => 'Registrar Cuenta Contable Bancaria', 'description' => 'Permiso para registrar cuentas contables bancarias']);
        $consultar_cuenta_contable_bancaria = Permission::firstOrCreate(['name' => 'consultar_cuenta_contable_bancaria', 'display_name' => 'Consultar Cuenta Contable Bancaria', 'description' => 'Permiso para consultar cuentas contables bancarias']);
        $editar_cuenta_contable_bancaria    = Permission::firstOrCreate(['name' => 'editar_cuenta_contable_bancaria', 'display_name' => 'Editar Cuenta Contable Bancaria', 'description' => 'Permiso para editar cuentas contables bancarias']);


        //PermisosCuentasCosto
        $eliminar_cuenta_costo  = Permission::firstOrCreate(['name' => 'eliminar_cuenta_costo', 'display_name' => 'Eliminar Cuenta de Costo', 'description' => 'Permiso para eliminar cuenta de costo']);
        $registrar_cuenta_costo = Permission::firstOrCreate(['name' => 'registrar_cuenta_costo', 'display_name' => 'Registrar Cuenta de Costo', 'description' => 'Permiso para registrar una cuenta de costo']);
        $consultar_cuenta_costo = Permission::firstOrCreate(['name' => 'consultar_cuenta_costo', 'display_name' => 'Consultar Cuenta de Costo', 'description' => 'Permiso para consultar la lista de cuentas de costos']);
        $editar_cuenta_costo    = Permission::firstOrCreate(['name' => 'editar_cuenta_costo', 'display_name' => 'Editar Cuenta de Costo', 'description' => 'Permiso para editar cuentas de Costos']);

        //Cierres de Periodo
        $consultar_cierre_periodo = Permission::firstOrCreate(['name' => 'consultar_cierre_periodo', 'display_name' => 'Cierre de Periodo', 'description' => 'Cierre de Periodo']);
        $generar_cierre_periodo = Permission::firstOrCreate(['name' => 'generar_cierre_periodo', 'display_name' => 'Generar Cierre Periodo', 'description' => 'Generar Cierre Periodo']);
        $editar_cierre_periodo = Permission::firstOrCreate(['name' => 'editar_cierre_periodo', 'display_name' => 'Editar Cierre Periodo', 'description' => 'Editar Cierre Periodo']);

        //Control Presupuesto Variación de Volúmen
        $registrar_variacion_volumen = Permission::firstOrCreate(['name' => 'registrar_variacion_volumen', 'display_name' => 'Registrar Variacion de Volúmen', 'description' => 'Registrar Variacion de Volúmen']);
        $autorizar_variacion_volumen = Permission::firstOrCreate(['name' => 'autorizar_variacion_volumen', 'display_name' =>
            'Autorizar Variacion de Volúmen', 'description' => 'Autorizar Variacion de Volúmen']);
        $aplicar_variacion_volumen = Permission::firstOrCreate(['name' => 'aplicar_variacion_volumen', 'display_name' => 'Aplicar Variacion de Volúmen', 'description' => 'Aplicar Variacion de Volúmen']);
        $rechazar_variacion_volumen = Permission::firstOrCreate(['name' => 'rechazar_variacion_volumen', 'display_name' =>
            'Rechazar Variacion de Volúmen', 'description' => 'Rechazar Variacion de Volúmen']);
        $consultar_variacion_volumen = Permission::firstOrCreate(['name' => 'consultar_variacion_volumen', 'display_name' =>
            'Consultar Variacion de Volúmen', 'description' => 'Consultar Variacion de Volúmen']);

        //Control Presupuesto Escalatoria
        $registrar_escalatoria = Permission::firstOrCreate(['name' => 'registrar_escalatoria', 'display_name' => 'Registrar Escalatoria', 'description' => 'Registrar Escalatoria']);
        $autorizar_escalatoria = Permission::firstOrCreate(['name' => 'autorizar_escalatoria', 'display_name' =>
            'Autorizar Escalatoria', 'description' => 'Autorizar Escalatoria']);
        $aplicar_escalatoria = Permission::firstOrCreate(['name' => 'aplicar_escalatoria', 'display_name' => 'Aplicar Escalatoria', 'description' => 'Aplicar Escalatoria']);
        $rechazar_escalatoria = Permission::firstOrCreate(['name' => 'rechazar_escalatoria', 'display_name' =>
            'Rechazar Escalatoria', 'description' => 'Rechazar Escalatoria']);
        $consultar_escalatoria = Permission::firstOrCreate(['name' => 'consultar_escalatoria', 'display_name' =>
            'Consultar Escalatoria', 'description' => 'Consultar Escalatoria']);

        /**
         * Roles
         */
        $contador          = Role::firstOrCreate(['name' => 'contador', 'display_name' => 'Contador', 'description' => 'Rol de Contador
']);
        $consultar         = Role::firstOrCreate(['name' => 'consultar', 'display_name' => 'Consultar
', 'description' => 'Rol para consultar
']);
        $control_proyecto  = Role::firstOrCreate(['name' => 'control_proyecto', 'display_name' => 'Control de Proyecto', 'description' => 'Rol de usuario de Control de Proyecto']);
        $jefe_subcontratos = Role::firstOrCreate(['name' => 'jefe_subcontratos', 'description' => 'Jefe de Subcontratos', 'display_name' => 'Jefe de Subcontratos']);
        $jefe_procuracion  = Role::firstOrCreate(['name' => 'jefe_procuracion', 'description' => 'Jefe de Procuración', 'display_name' => 'Jefe de Procuración']);
        $tesorero          = Role::firstOrCreate(['name' => 'tesorero', 'display_name' => 'Tesorero', 'description' => 'Rol para operar el sistema de finanzas']);
        $consulta_finanzas = Role::firstOrCreate(['name' => 'consulta_finanzas', 'display_name' => 'Consulta Finanzas', 'description' => 'Rol para consultar el sistema de finanzas']);
        $coordinador_control_proyectos = Role::firstOrCreate(['name' => 'coordinador_control_proyectos', 'display_name' => 'Coordinador de Control de Proyectos', 'description' => 'Coordinador de Control de Proyectos']);

        /**
         * Asignaciones
         */

        $control_proyecto->perms()->sync([$solicitar_reclasificacion->id, $autorizar_reclasificacion->id, $consultar_reclasificacion->id]);
        $jefe_procuracion->perms()->sync([$consultar_reporte_estimacion->id]);
        $jefe_subcontratos->perms()->sync([$consultar_reporte_estimacion->id]);
        $contador->perms()->sync([$editar_cuenta_fondo->id, $registrar_cuenta_fondo->id, $consultar_cuenta_fondo->id]);
        $consultar->perms()->sync([$consultar_cuenta_fondo->id]);
        $contador->perms()->sync([$editar_cuenta_costo->id, $registrar_cuenta_costo->id, $consultar_cuenta_costo->id, $eliminar_cuenta_costo->id]);
        $tesorero->perms()->sync([$editar_comprobante_fondo_fijo->id, $registrar_comprobante_fondo_fijo->id, $consultar_comprobante_fondo_fijo->id,$eliminar_comprobante_fondo_fijo->id]);
        $consulta_finanzas->perms()->sync([$consultar_comprobante_fondo_fijo->id]);
        $contador->perms()->sync([$consultar_cierre_periodo->id, $generar_cierre_periodo->id, $editar_cierre_periodo->id]);
        $control_proyecto->perms()->sync([$consultar_cierre_periodo->id]);
        $coordinador_control_proyectos->perms()->sync([
            $registrar_variacion_volumen->id,
            $autorizar_variacion_volumen->id,
            $aplicar_variacion_volumen->id,
            $rechazar_variacion_volumen->id,
            $consultar_variacion_volumen->id,
            $registrar_escalatoria->id,
            $autorizar_escalatoria->id,
            $aplicar_escalatoria->id,
            $rechazar_escalatoria->id,
            $consultar_escalatoria->id,
        ]);
    }
}
