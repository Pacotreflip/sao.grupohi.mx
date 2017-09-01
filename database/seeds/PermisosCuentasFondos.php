<?php

use Illuminate\Database\Seeder;

class PermisosCuentasFondos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'editar_cuenta_fondo', 'display_name' => 'Editar Cuenta de Fondo', 'description' => 'Permiso para editar una cuenta contable registrada en un Fondo']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'registrar_cuenta_fondo', 'display_name' => 'Registrar Cuenta de Fondo', 'description' => 'Permiso para registrar una cuenta contable en un Fondo']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_cuenta_fondo', 'display_name' => 'Consultar Cuenta de Fondo', 'description' => 'Permiso para consultar una o varias cuentas contables de Fondo']);
    }
}
