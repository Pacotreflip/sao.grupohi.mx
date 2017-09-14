<?php

use Illuminate\Database\Seeder;

class RolePermissionsComprobanteFondoFijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();

        DB::connection('seguridad')->table('dbo.permissions')->insert([

           //comprobante de fondo fijo
            ['name' => 'editar_comprobante_fondo_fijo', 'display_name' => 'Editar Comprobante de Fondo Fijo', 'description' => 'Permiso para editar un Comprobante de Fondo Fijo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'registrar_comprobante_fondo_fijo', 'display_name' => 'Registrar Comprobante de Fondo Fijo', 'description' => 'Permiso para registrar un Comprobante de Fondo Fijo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'consultar_comprobante_fondo_fijo', 'display_name' => 'Consultar Comprobante de Fondo Fijo', 'description' => 'Permiso para consultar un Comprobante de Fondo Fijo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'eliminar_comprobante_fondo_fijo', 'display_name' => 'Eliminar Comprobante de Fondo Fijo', 'description' => 'Permiso para eliminar un Comprobante de Fondo Fijo', 'created_at' => $now, 'updated_at' => $now],

                 ]);

    }
}

