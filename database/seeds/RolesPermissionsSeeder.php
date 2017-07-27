<?php

use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        DB::connection('seguridad')->table('dbo.permissions')->delete();
        DB::connection('seguridad')->table('dbo.permissions')->insert([

            // Cuentas de Almacén
            ['name' => 'editar_cuenta_almacen', 'display_name' => 'Editar Cuenta de Almacén', 'description' => 'Permiso para editar una cuenta contable registrada en un Almacén', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_cuenta_almacen', 'display_name' => 'Registrar Cuenta de Almacén', 'description' => 'Permiso para registrar una cuenta contable en un Almacén', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'consultar_cuenta_almacen', 'display_name' => 'Consultar Cuenta de Almacén', 'description' => 'Permiso para consultar una o varias cuentas contables de Almacén', 'created_at' => $now, 'updated_at' => $now],

            // Cuentas Conceptos
            ['name' => 'editar_cuenta_concepto', 'display_name' => 'Editar Cuenta de Concepto', 'description' => 'Permiso para editar una cuenta contable registrada en un Concepto', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_cuenta_concepto', 'display_name' => 'Registrar Cuenta de Concepto', 'description' => 'Permiso para registrar una cuenta contable en un Concepto', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'consultar_cuenta_concepto', 'display_name' => 'Consultar Cuenta de Concepto', 'description' => 'Permiso para consultar una o varias cuentas contables de Concepto', 'created_at' => $now, 'updated_at' => $now],

            // Cuentas Empresas
            ['name' => 'editar_cuenta_empresa', 'display_name' => 'Editar Cuenta de Empresa', 'description' => 'Permiso para editar una cuenta contable registrada en una Empresa', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_cuenta_empresa', 'display_name' => 'Registrar Cuenta de Empresa', 'description' => 'Permiso para registrar una cuenta contable en una Empresa', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'consultar_cuenta_empresa', 'display_name' => 'Consultar Cuenta de Empresa', 'description' => 'Permiso para consultar una o varias cuentas contables de Empresa', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'eliminar_cuenta_empresa', 'display_name' => 'Eliminar Cuenta de Empresa', 'description' => 'Permiso para eliminar cuentas contables de Empresa', 'created_at' => $now, 'updated_at' => $now],

            // Cuentas Generales
            ['name' => 'consultar_cuenta_general', 'display_name' => 'Consultar Cuenta General', 'description' => 'Permiso para consultar una o varias Cuentas Contables Generales', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_cuenta_general', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable General', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'editar_cuenta_general', 'display_name' => 'Editar Cuenta General', 'description' => 'Permiso para editar una cuenta contable General', 'created_at' => $now, 'updated_at' => $now],

            // Cuentas Materiales
            ['name' => 'consultar_cuenta_material', 'display_name' => 'Consultar Cuenta de Material', 'description' => 'Permiso para consultar una o varias cuentas contables de materiales', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_cuenta_material', 'display_name' => 'Registrar Cuenta General', 'description' => 'Permiso para registrar una cuenta contable en un Material', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'editar_cuenta_material', 'display_name' => 'Editar Cuenta Metarial', 'description' => 'Permiso para editar una cuenta contable registrada en un Material', 'created_at' => $now, 'updated_at' => $now],

            // Tipo Cuenta Contable
            ['name' => 'consultar_tipo_cuenta_contable', 'display_name' => 'Consultar Tipo de Cuenta Contable', 'description' => 'Permiso para consultar uno o varios tipos de cuenta contable', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_tipo_cuenta_contable', 'display_name' => 'Registrar Tipo de Cuenta Contable', 'description' => 'Permiso para registrar un tipo de cuenta contable', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'editar_tipo_cuenta_contable', 'display_name' => 'Editar Tipo de Cuenta Contable', 'description' => 'Permiso para editar un tipo de cuenta contable', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'eliminar_tipo_cuenta_contable', 'display_name' => 'Eliminar Tipo de Cuenta Contable', 'description' => 'Permiso para eliminar un tipo de cuenta contable', 'created_at' => $now, 'updated_at' => $now],

            // Plantillas de Prepólizas
            ['name' => 'consultar_plantilla_prepoliza', 'display_name' => 'Consultar Plantilla de Prepóliza', 'description' => 'Permiso para consultar una o varias plantillas de Prepólizas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_plantilla_prepoliza', 'display_name' => 'Registrar Plantilla de Prepóliza', 'description' => 'Permiso para registrar  plantillas de Prepólizas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'eliminar_plantilla_prepoliza', 'display_name' => 'Eliminar Plantilla de Prepóliza', 'description' => 'Permiso para eliminar plantillas de Prepólizas', 'created_at' => $now, 'updated_at' => $now],

            // Configuración contable
            ['name' => 'editar_configuracion_contable', 'display_name' => 'Editar Configuración Contable', 'description' => 'Permiso para editar la configuración Contable de la obra en contexto', 'created_at' => $now, 'updated_at' => $now],

            // Prepólizas Generadas
            ['name' => 'consultar_prepolizas_generadas', 'display_name' => 'Consultar Prepólizas Generadas', 'description' => 'Permiso para consultar una o varias Prepólizas Generadas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'editar_prepolizas_generadas', 'display_name' => 'Editar Prepólizas Generadas', 'description' => 'Permiso para editar las Prepólizas Generadas', 'created_at' => $now, 'updated_at' => $now],
            
            // Kardex Material
            ['name' => 'consultar_kardex_material', 'display_name' => 'Consultar Kardex de Materiales', 'description' => 'Permiso para consultar el Kardex de Materiales', 'created_at' => $now, 'updated_at' => $now]
        ]);

        DB::connection('seguridad')->table('dbo.roles')->delete();
            DB::connection('seguridad')->table('dbo.roles')->insert([
            ['name' => 'contador', 'display_name' => 'Contador', 'description' => 'Rol de Contador', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'consultar', 'display_name' => 'Consultar', 'description' => 'Rol para consultar', 'created_at' => $now, 'updated_at' => $now]
        ]);
    }
}
