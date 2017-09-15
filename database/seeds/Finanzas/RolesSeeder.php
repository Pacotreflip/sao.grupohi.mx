<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tesorero = \Ghi\Domain\Core\Models\Seguridad\Role::create(['name' => 'tesorero', 'display_name' => 'Tesorero', 'description' => 'Rol para operar el sistema de finanzas']);
        $consulta_finanzas = \Ghi\Domain\Core\Models\Seguridad\Role::create(['name' => 'consulta_finanzas', 'display_name' => 'Consulta Finanzas', 'description' => 'Rol para consultar el sistema de finanzas']);

        $editar_comprobante_fondo_fijo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'editar_comprobante_fondo_fijo')->first();
        $registrar_comprobante_fondo_fijo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'registrar_comprobante_fondo_fijo')->first();
        $consultar_comprobante_fondo_fijo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'consultar_comprobante_fondo_fijo')->first();
        $eliminar_comprobante_fondo_fijo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'eliminar_comprobante_fondo_fijo')->first();


        $tesorero->attachPermissions([$editar_comprobante_fondo_fijo, $registrar_comprobante_fondo_fijo, $consultar_comprobante_fondo_fijo,$eliminar_comprobante_fondo_fijo]);
        $consulta_finanzas->attachPermission($consultar_comprobante_fondo_fijo);

    }
}
