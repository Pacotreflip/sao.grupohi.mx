<?php

use Ghi\Domain\Core\Models\Seguridad\Permission;
use Ghi\Domain\Core\Models\Seguridad\Sistema;
use Illuminate\Database\Seeder;

class SistemasPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Sistemas
         */
        $sistema_contable = Sistema::firstOrCreate(['name' => 'Sistema Contable', 'description' => 'Sistema para el control contable', 'url' => 'sistema_contable']);
        $finaznas = Sistema::firstOrCreate(['name' => 'Finanzas', 'description' => 'Sistema para el control financiero', 'url' => 'finanzas']);
        $formatos = Sistema::firstOrCreate(['name' => 'Formatos', 'description' => 'Sistema de emisión de formatos', 'url' => 'formatos']);
        $tesoreria = Sistema::firstOrCreate(['name' => 'Tesorería', 'description' => 'Sistema de Tesorería', 'url' => 'tesoreria']);
        $control_costos = Sistema::firstOrCreate(['name' => 'Control de Costos', 'description' => 'Sistema de control de costos', 'url' => 'control_costos']);
        $control_presupuesto = Sistema::firstOrCreate(['name' => 'Control del Presupuesto', 'description' => 'Sistema para el control del presupuesto', 'url' => 'control_presupuesto']);

        /**
         * Relacion con permisos
         */
        $sistema_contable->permisos()->sync(
            Permission::whereIn('name', [
                'editar_cuenta_almacen',
                'registrar_cuenta_almacen',
                'consultar_cuenta_almacen',
                'editar_cuenta_concepto',
                'registrar_cuenta_concepto',
                'consultar_cuenta_concepto',
                'editar_cuenta_empresa',
                'registrar_cuenta_empresa',
                'consultar_cuenta_empresa',
                'eliminar_cuenta_empresa',
                'consultar_cuenta_general',
                'registrar_cuenta_general',
                'editar_cuenta_general',
                'consultar_cuenta_material',
                'registrar_cuenta_material',
                'editar_cuenta_material',
                'consultar_tipo_cuenta_contable',
                'registrar_tipo_cuenta_contable',
                'editar_tipo_cuenta_contable',
                'eliminar_tipo_cuenta_contable',
                'consultar_plantilla_prepoliza',
                'registrar_plantilla_prepoliza',
                'eliminar_plantilla_prepoliza',
                'editar_configuracion_contable',
                'consultar_prepolizas_generadas',
                'editar_prepolizas_generadas',
                'consultar_kardex_material',
                'editar_cuenta_fondo',
                'registrar_cuenta_fondo',
                'consultar_cuenta_fondo',
                'eliminar_cuenta_contable_bancaria',
                'registrar_cuenta_contable_bancaria',
                'consultar_cuenta_contable_bancaria',
                'editar_cuenta_contable_bancaria',
                'eliminar_cuenta_costo',
                'registrar_cuenta_costo',
                'consultar_cuenta_costo',
                'editar_cuenta_costo',
                'consultar_cierre_periodo',
                'generar_cierre_periodo',
                'editar_cierre_periodo'

            ])->lists('id')->toArray()
        );

        $finaznas->permisos()->sync(
            Permission::whereIn('name', [
                'editar_comprobante_fondo_fijo',
                'registrar_comprobante_fondo_fijo',
                'consultar_comprobante_fondo_fijo',
                'eliminar_comprobante_fondo_fijo'
            ])->lists('id')->toArray()
        );

        $formatos->permisos()->sync(
            Permission::whereIn('name', [
                'consultar_formato_estimacion'
            ])->lists('id')->toArray()
        );

        $tesoreria->permisos()->sync(
            Permission::whereIn('name', [
                'eliminar_traspaso_cuenta',
                'registrar_traspaso_cuenta',
                'consultar_traspaso_cuenta',
                'editar_traspaso_cuenta',
                'eliminar_movimiento_bancario',
                'registrar_movimiento_bancario',
                'consultar_movimiento_bancario',
                'editar_movimiento_bancario'
            ])->lists('id')->toArray()
        );

        $control_costos->permisos()->sync(
            Permission::whereIn('name', [
                'solicitar_reclasificacion',
                'autorizar_reclasificacion',
                'consultar_reclasificacion'
            ])->lists('id')->toArray()
        );

        $control_presupuesto->permisos()->sync(
            Permission::whereIn('name', [
                'registrar_variacion_volumen',
                'autorizar_variacion_volumen',
                'aplicar_variacion_volumen',
                'rechazar_variacion_volumen',
                'consultar_variacion_volumen',
                'registrar_escalatoria',
                'autorizar_escalatoria',
                'aplicar_escalatoria',
                'rechazar_escalatoria',
                'consultar_escalatoria',
            ])->lists('id')->toArray()
        );
    }
}