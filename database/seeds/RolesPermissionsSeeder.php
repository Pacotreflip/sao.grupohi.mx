<?php

use Ghi\Domain\Core\Models\Seguridad\Sistema;
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

        //Formatos
        $consultar_formato_estimacion = Permission::firstOrCreate(['name' => 'consultar_formato_estimacion', 'description' => 'Consultar Formato de Orden de Pago Estimación', 'display_name' => 'Consultar Formato de Orden de Pago Estimación']);
        $consultar_formato_comparativa_presupuestos = Permission::firstOrCreate(['name' => 'consultar_formato_comparativa_presupuestos', 'description' => 'Consultar Formato de Tabla Comparativa de Presupuestos', 'display_name' => 'Consultar Formato de Tabla Comparativa de Presupuestos']);

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
        $consultar_cierre_periodo = Permission::firstOrCreate(['name' => 'consultar_cierre_periodo', 'display_name' => 'Consultar Cierre de Periodo', 'description' => 'Consultar Cierre de Periodo']);
        $generar_cierre_periodo = Permission::firstOrCreate(['name' => 'generar_cierre_periodo', 'display_name' => 'Generar Cierre Periodo', 'description' => 'Generar Cierre Periodo']);
        $editar_cierre_periodo = Permission::firstOrCreate(['name' => 'editar_cierre_periodo', 'display_name' => 'Editar Cierre Periodo', 'description' => 'Editar Cierre Periodo']);

        //Control Presupuesto Variación de Volúmen
        $registrar_variacion_volumen = Permission::firstOrCreate(['name' => 'registrar_variacion_volumen', 'display_name' => 'Registrar Variacion de Volúmen', 'description' => 'Registrar Variacion de Volúmen']);
        $autorizar_variacion_volumen = Permission::firstOrCreate(['name' => 'autorizar_variacion_volumen', 'display_name' => 'Autorizar Variacion de Volúmen', 'description' => 'Autorizar Variacion de Volúmen']);
        $aplicar_variacion_volumen = Permission::firstOrCreate(['name' => 'aplicar_variacion_volumen', 'display_name' => 'Aplicar Variacion de Volúmen', 'description' => 'Aplicar Variacion de Volúmen']);
        $rechazar_variacion_volumen = Permission::firstOrCreate(['name' => 'rechazar_variacion_volumen', 'display_name' => 'Rechazar Variacion de Volúmen', 'description' => 'Rechazar Variacion de Volúmen']);
        $consultar_variacion_volumen = Permission::firstOrCreate(['name' => 'consultar_variacion_volumen', 'display_name' => 'Consultar Variacion de Volúmen', 'description' => 'Consultar Variacion de Volúmen']);

        //Control Presupuesto Escalatoria
        $registrar_escalatoria = Permission::firstOrCreate(['name' => 'registrar_escalatoria', 'display_name' => 'Registrar Escalatoria', 'description' => 'Registrar Escalatoria']);
        $autorizar_escalatoria = Permission::firstOrCreate(['name' => 'autorizar_escalatoria', 'display_name' => 'Autorizar Escalatoria', 'description' => 'Autorizar Escalatoria']);
        $aplicar_escalatoria = Permission::firstOrCreate(['name' => 'aplicar_escalatoria', 'display_name' => 'Aplicar Escalatoria', 'description' => 'Aplicar Escalatoria']);
        $rechazar_escalatoria = Permission::firstOrCreate(['name' => 'rechazar_escalatoria', 'display_name' => 'Rechazar Escalatoria', 'description' => 'Rechazar Escalatoria']);
        $consultar_escalatoria = Permission::firstOrCreate(['name' => 'consultar_escalatoria', 'display_name' => 'Consultar Escalatoria', 'description' => 'Consultar Escalatoria']);

        //Control Presupuesto cambio de insumos
        $registrar_cambio_insumos = Permission::firstOrCreate(['name' => 'registrar_cambio_insumos', 'display_name' => 'Registrar Cambio de Insumos', 'description' => 'Registrar Cambio de Insumos']);
        $autorizar_cambio_insumos = Permission::firstOrCreate(['name' => 'autorizar_cambio_insumos', 'display_name' => 'Autorizar Cambio de Insumos', 'description' => 'Autorizar Cambio de Insumos']);
        $rechazar_cambio_insumos= Permission::firstOrCreate(['name' => 'rechazar_cambio_insumos', 'display_name' => 'Rechazar Cambio de Insumos', 'description' => 'Rechazar Cambio de Insumos']);
        $consultar_cambio_insumos = Permission::firstOrCreate(['name' => 'consultar_cambio_insumos', 'display_name' => 'Consultar Cambio de Insumos', 'description' => 'Consultar Cambio de Insumos']);

        //Control Presupuesto cambio de insumos
        $registrar_cambio_cantidad_insumos = Permission::firstOrCreate(['name' => 'registrar_cambio_cantidad_insumos', 'display_name' => 'Registrar Cambio de Cantidad de Insumos', 'description' => 'Registrar Cambio de Cantidad de Insumos']);
        $autorizar_cambio_cantidad_insumos = Permission::firstOrCreate(['name' => 'autorizar_cambio_cantidad_insumos', 'display_name' => 'Autorizar Cambio de Cantidad de Insumos', 'description' => 'Autorizar Cambio de Cantidad de Insumos']);
        $rechazar_cambio_cantidad_insumos= Permission::firstOrCreate(['name' => 'rechazar_cambio_cantidad_insumos', 'display_name' => 'Rechazar Cambio de Cantidad de Insumos', 'description' => 'Rechazar Cambio de Cantidad de Insumos']);
        $consultar_cambio_cantidad_insumos = Permission::firstOrCreate(['name' => 'consultar_cambio_cantidad_insumos', 'display_name' => 'Consultar Cambio de Cantidad  de Insumos', 'description' => 'Consultar Cambio de Cantidad de Insumos']);

        //Roles y Permisos
        $administrar_roles_permisos = Permission::firstOrCreate(['name' => 'administrar_roles_permisos', 'display_name' => 'Administrar Roles y Permisos', 'description' => 'Permisos para asignación de roles a usuarios']);
        $administracion_configuracion_obra = Permission::firstOrCreate(['name' => 'administracion_configuracion_obra', 'display_name' => 'Configuración de la estructura la obra', 'description' => 'Permisos para configuración de la estructura de obra']);
        $administracion_configuracion_presupuesto = Permission::firstOrCreate(['name' => 'administracion_configuracion_presupuesto', 'display_name' => 'Configuración de la estructura del presupuesto', 'description' => 'Permisos para configuración de la estructura del presupuesto']);

        //Procuaracion Asignación de Proveedores
        $consultar_asignacion = Permission::firstOrCreate(['name' => 'consultar_asignacion', 'display_name' => 'Consultar Asignación', 'description' => 'Permisos para la asignación de la consulta de procuración de las asignaciones']);
        $resgistro_asignacion = Permission::firstOrCreate(['name' => 'registrar_asignacion', 'display_name' => 'Registrar una Asignación', 'description' => 'Permisos para el registro de una asignación de procuración']);
        $eliminar_asignacion = Permission::firstOrCreate(['name' => 'eliminar_asignacion', 'display_name' => 'Eliminar una Asignación', 'description' => 'Permisos para poder eliminar el registro de una asignación de procuración']);

        //Finanzas Solicitud de Pago
        $registrar_reposicion_fondo_fijo = Permission::firstOrCreate(['name' => 'registrar_reposicion_fondo_fijo', 'display_name' => 'Registrar Reposicion de fondo fijo', 'description' => 'Permiso para poder registrar reposiciones de fondo fijo']);
        $registrar_pago_cuenta = Permission::firstOrCreate(['name' => 'registrar_pago_cuenta', 'display_name' => 'Registrar pagos a cuenta', 'description' => 'Permiso para poder registrar pagos a cuenta']);
        $consultar_solicitud_pago = Permission::firstOrCreate(['name' => 'consultar_solicitud_pago', 'display_name' => 'Consultar Solicitudes de Pago', 'description' => 'Permiso para poder Consultar Solicitudes de Pago']);

        //Finanzas Solicitud de Recursos
        $registrar_solicitud_recursos = Permission::firstOrCreate(['name' => 'registrar_solicitud_recursos', 'display_name' => 'Registrar Solicitudes de Recursos', 'description' => 'Permiso para poder Registrar Solicitudes de Recursos']);

        $consultar_solicitud_recursos = Permission::firstOrCreate(['name' => 'consultar_solicitud_recursos', 'display_name' => 'Consultar Solicitudes de Recursos', 'description' => 'Permiso para poder Consultar Solicitudes de Recursos']);
        $modificar_solicitud_recursos = Permission::firstOrCreate(['name' => 'modificar_solicitud_recursos', 'display_name' => 'Modificar Solicitudes de Recursos', 'description' => 'Permiso para poder Modificar Solicitudes de Recursos']);
        $eliminar_solicitud_recursos = Permission::firstOrCreate(['name' => 'eliminar_solicitud_recursos', 'display_name' => 'Eliminar Solicitudes de Recursos', 'description' => 'Permiso para poder Eliminar Solicitudes de Recursos']);

        /**
         * Roles
         */
        $contador                      = Role::firstOrCreate(['name' => 'contador', 'display_name' => 'Contador', 'description' => 'Rol de Contador']);
        $consulta_sistema_contable     = Role::firstOrCreate(['name' => 'consulta_sistema_contable', 'display_name' => 'Consulta Sistema Contable', 'description' => 'Rol para consulta dentro del sistema contable']);
        $tesorero                      = Role::firstOrCreate(['name' => 'tesorero', 'display_name' => 'Tesorero', 'description' => 'Rol para operar el sistema de finanzas']);
        $consulta_finanzas             = Role::firstOrCreate(['name' => 'consulta_finanzas', 'display_name' => 'Consulta Finanzas', 'description' => 'Rol para consultar el sistema de finanzas']);
        $jefe_subcontratos             = Role::firstOrCreate(['name' => 'jefe_subcontratos', 'description' => 'Jefe de Subcontratos', 'display_name' => 'Jefe de Subcontratos']);
        $jefe_procuracion              = Role::firstOrCreate(['name' => 'jefe_procuracion', 'description' => 'Jefe de Procuración', 'display_name' => 'Jefe de Procuración']);
        $coordinador_sao               = Role::firstOrCreate(['name' => 'coordinador_sao', 'description' => 'Coordinador SAO', 'display_name' => 'Coordinador SAO']);
        $control_proyecto              = Role::firstOrCreate(['name' => 'control_proyecto', 'display_name' => 'Control de Proyecto', 'description' => 'Rol de usuario de Control de Proyecto']);
        $coordinador_control_proyectos = Role::firstOrCreate(['name' => 'coordinador_control_proyectos', 'display_name' => 'Coordinador de Control de Proyectos', 'description' => 'Coordinador de Control de Proyectos']);
        $administrador_sistema         = Role::firstOrCreate(['name' => 'administrador_sistema', 'display_name' => 'Administrador del Sistema', 'description' => 'Administrador del Sistema']);
        $comprador                     = Role::firstOrCreate(['name' => 'comprador', 'display_name' => 'Comprador', 'description' => 'Rol de Procuración']);
        $coordinador_procuracion       = Role::firstOrCreate(['name' => 'coordinador_procuracion', 'display_name' => 'Coordinador Procuracion', 'description' => 'Rol de Coordinador Procuración']);

        /**
         * Asignaciones
         */

        $contador->perms()->sync([
            $editar_cuenta_almacen->id,
            $registrar_cuenta_almacen->id,
            $consultar_cuenta_almacen->id,
            $editar_cuenta_concepto->id,
            $registrar_cuenta_concepto->id,
            $consultar_cuenta_concepto->id,
            $editar_cuenta_empresa->id,
            $registrar_cuenta_empresa->id,
            $consultar_cuenta_empresa->id,
            $eliminar_cuenta_empresa->id,
            $consultar_cuenta_general->id,
            $registrar_cuenta_general->id,
            $editar_cuenta_general->id,
            $consultar_cuenta_material->id,
            $registrar_cuenta_material->id,
            $editar_cuenta_material->id,
            $consultar_tipo_cuenta_contable->id,
            $registrar_tipo_cuenta_contable->id,
            $editar_tipo_cuenta_contable->id,
            $eliminar_tipo_cuenta_contable->id,
            $consultar_plantilla_prepoliza->id,
            $registrar_plantilla_prepoliza->id,
            $eliminar_plantilla_prepoliza->id,
            $editar_configuracion_contable->id,
            $consultar_prepolizas_generadas->id,
            $editar_prepolizas_generadas->id,
            $consultar_kardex_material->id,
            $editar_cuenta_fondo->id,
            $registrar_cuenta_fondo->id,
            $consultar_cuenta_fondo->id,
            $eliminar_cuenta_contable_bancaria->id,
            $registrar_cuenta_contable_bancaria->id,
            $consultar_cuenta_contable_bancaria->id,
            $editar_cuenta_contable_bancaria->id,
            $eliminar_cuenta_costo->id,
            $registrar_cuenta_costo->id,
            $consultar_cuenta_costo->id,
            $editar_cuenta_costo->id,
            $solicitar_reclasificacion->id,
            $consultar_reclasificacion->id,
            $consultar_cierre_periodo->id,
            $generar_cierre_periodo->id,
            $editar_cierre_periodo->id
        ]);
        $consulta_sistema_contable->perms()->sync([
            $consultar_cuenta_almacen->id,
            $consultar_cuenta_concepto->id,
            $consultar_cuenta_empresa->id,
            $consultar_cuenta_general->id,
            $consultar_cuenta_material->id,
            $consultar_tipo_cuenta_contable->id,
            $consultar_plantilla_prepoliza->id,
            $consultar_prepolizas_generadas->id,
            $consultar_kardex_material->id,
            $consultar_cuenta_fondo->id
        ]);
        $tesorero->perms()->sync([
            $editar_comprobante_fondo_fijo->id,
            $registrar_comprobante_fondo_fijo->id,
            $consultar_comprobante_fondo_fijo->id,
            $eliminar_comprobante_fondo_fijo->id,
            $eliminar_traspaso_cuenta->id,
            $registrar_traspaso_cuenta->id,
            $consultar_traspaso_cuenta->id,
            $editar_traspaso_cuenta->id,
            $eliminar_movimiento_bancario->id,
            $registrar_movimiento_bancario->id,
            $consultar_movimiento_bancario->id,
            $editar_movimiento_bancario->id,
            $registrar_pago_cuenta->id,
            $registrar_reposicion_fondo_fijo->id,
            $consultar_solicitud_pago->id,
            $registrar_solicitud_recursos->id,
        ]);
        $consulta_finanzas->perms()->sync([
            $consultar_comprobante_fondo_fijo->id,
            $consultar_traspaso_cuenta->id,
            $consultar_movimiento_bancario->id,
        ]);
        $jefe_subcontratos->perms()->sync([
            $consultar_formato_estimacion->id,
            $consultar_formato_comparativa_presupuestos->id,
        ]);
        $jefe_procuracion->perms()->sync([
            $consultar_formato_estimacion->id,
        ]);
        $coordinador_sao->perms()->sync([
            $consultar_cuenta_almacen->id,
            $consultar_cuenta_concepto->id,
            $consultar_cuenta_empresa->id,
            $consultar_cuenta_general->id,
            $consultar_cuenta_material->id,
            $consultar_tipo_cuenta_contable->id,
            $consultar_plantilla_prepoliza->id,
            $consultar_prepolizas_generadas->id,
            $consultar_cuenta_fondo->id,
            $registrar_comprobante_fondo_fijo->id,
            $consultar_comprobante_fondo_fijo->id,
            $eliminar_comprobante_fondo_fijo->id,
            $consultar_formato_estimacion->id,
            $consultar_movimiento_bancario->id,
            $consultar_cuenta_contable_bancaria->id,
            $consultar_cuenta_costo->id,
            $consultar_reclasificacion->id,
        ]);
        $control_proyecto->perms()->sync([
            $solicitar_reclasificacion->id,
            $autorizar_reclasificacion->id,
            $consultar_reclasificacion->id,
            $consultar_cierre_periodo->id,
        ]);
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
            $registrar_cambio_insumos->id,
            $autorizar_cambio_insumos->id,
            $rechazar_cambio_insumos->id,
            $consultar_cambio_insumos->id,
            $registrar_cambio_cantidad_insumos->id,
            $autorizar_cambio_cantidad_insumos->id,
            $rechazar_cambio_cantidad_insumos->id,
            $consultar_cambio_cantidad_insumos->id,
        ]);
        $administrador_sistema->perms()->sync([
            $administrar_roles_permisos->id,
            $administracion_configuracion_presupuesto->id,
            $administracion_configuracion_obra->id,
        ]);

        $coordinador_procuracion->perms()->sync([
            $consultar_asignacion->id,
            $resgistro_asignacion->id,
            $eliminar_asignacion->id,
        ]);
        /**
         * Sistemas
         */
        $sistema_contable = Sistema::firstOrCreate(['name' => 'Sistema Contable', 'description' => 'Sistema para el control contable', 'url' => 'sistema_contable']);
        $finanzas = Sistema::firstOrCreate(['name' => 'Finanzas', 'description' => 'Sistema para el control financiero', 'url' => 'finanzas']);
        $formatos = Sistema::firstOrCreate(['name' => 'Formatos', 'description' => 'Sistema de emisión de formatos', 'url' => 'formatos']);
        $tesoreria = Sistema::firstOrCreate(['name' => 'Tesorería', 'description' => 'Sistema de Tesorería', 'url' => 'tesoreria']);
        $control_costos = Sistema::firstOrCreate(['name' => 'Control de Costos', 'description' => 'Sistema de control de costos', 'url' => 'control_costos']);
        $control_presupuesto = Sistema::firstOrCreate(['name' => 'Control del Presupuesto', 'description' => 'Sistema para el control del presupuesto', 'url' => 'control_presupuesto']);
        $procuracion = Sistema::firstOrCreate(['name' => 'Procuración', 'description' => 'Sistema para el control de asignación', 'url' => 'procuracion']);

        $sistema_contable->permisos()->sync(
            [
                $editar_cuenta_almacen->id,
                $registrar_cuenta_almacen->id,
                $consultar_cuenta_almacen->id,
                $editar_cuenta_concepto->id,
                $registrar_cuenta_concepto->id,
                $consultar_cuenta_concepto->id,
                $editar_cuenta_empresa->id,
                $registrar_cuenta_empresa->id,
                $consultar_cuenta_empresa->id,
                $eliminar_cuenta_empresa->id,
                $consultar_cuenta_general->id,
                $registrar_cuenta_general->id,
                $editar_cuenta_general->id,
                $consultar_cuenta_material->id,
                $registrar_cuenta_material->id,
                $editar_cuenta_material->id,
                $consultar_tipo_cuenta_contable->id,
                $registrar_tipo_cuenta_contable->id,
                $editar_tipo_cuenta_contable->id,
                $eliminar_tipo_cuenta_contable->id,
                $consultar_plantilla_prepoliza->id,
                $registrar_plantilla_prepoliza->id,
                $eliminar_plantilla_prepoliza->id,
                $editar_configuracion_contable->id,
                $consultar_prepolizas_generadas->id,
                $editar_prepolizas_generadas->id,
                $consultar_kardex_material->id,
                $editar_cuenta_fondo->id,
                $registrar_cuenta_fondo->id,
                $consultar_cuenta_fondo->id,
                $eliminar_cuenta_contable_bancaria->id,
                $registrar_cuenta_contable_bancaria->id,
                $consultar_cuenta_contable_bancaria->id,
                $editar_cuenta_contable_bancaria->id,
                $eliminar_cuenta_costo->id,
                $registrar_cuenta_costo->id,
                $consultar_cuenta_costo->id,
                $editar_cuenta_costo->id,
                $consultar_cierre_periodo->id,
                $generar_cierre_periodo->id,
                $editar_cierre_periodo->id,
            ]
        );
        //Finanzas
        $finanzas->permisos()->sync(
            [
                $editar_comprobante_fondo_fijo->id,
                $registrar_comprobante_fondo_fijo->id,
                $consultar_comprobante_fondo_fijo->id,
                $eliminar_comprobante_fondo_fijo->id,

                $registrar_reposicion_fondo_fijo->id,
                $registrar_pago_cuenta->id,
                $consultar_solicitud_pago->id,


                $registrar_solicitud_recursos->id,
                $consultar_solicitud_recursos->id,
                $modificar_solicitud_recursos->id,
                $eliminar_solicitud_recursos->id

            ]
        );

        $formatos->permisos()->sync(
            [
                $consultar_formato_estimacion->id,
                $consultar_formato_comparativa_presupuestos->id,
            ]
        );

        $tesoreria->permisos()->sync(
            [
                $eliminar_traspaso_cuenta->id,
                $registrar_traspaso_cuenta->id,
                $consultar_traspaso_cuenta->id,
                $editar_traspaso_cuenta->id,
                $eliminar_movimiento_bancario->id,
                $registrar_movimiento_bancario->id,
                $consultar_movimiento_bancario->id,
                $editar_movimiento_bancario->id,
            ]
        );

        $control_costos->permisos()->sync(
            [
                $solicitar_reclasificacion->id,
                $autorizar_reclasificacion->id,
                $consultar_reclasificacion->id,
            ]
        );

        $control_presupuesto->permisos()->sync(
            [
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
                $registrar_cambio_cantidad_insumos->id,
                $autorizar_cambio_cantidad_insumos->id,
                $rechazar_cambio_cantidad_insumos->id,
                $consultar_cambio_cantidad_insumos->id
            ]
        );

        $procuracion->permisos()->sync(
            [
                $resgistro_asignacion->id,
                $consultar_asignacion->id,
                $eliminar_asignacion->id,
            ]
        );
    }
}
