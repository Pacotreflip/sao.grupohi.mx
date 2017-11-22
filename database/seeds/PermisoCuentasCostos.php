<?php

use Illuminate\Database\Seeder;

class PermisoCuentasCostos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'eliminar_cuenta_costo', 'display_name' => 'Eliminar Cuenta de Costo', 'description' => 'Permiso para eliminar cuenta de costo']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'registrar_cuenta_costo', 'display_name' => 'Registrar Cuenta de Costo', 'description' => 'Permiso para registrar una cuenta de costo']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_cuenta_costo', 'display_name' => 'Consultar Cuenta de Costo', 'description' => 'Permiso para consultar la lista de cuentas de costos']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'editar_cuenta_costo', 'display_name' => 'Editar Cuenta de Costo', 'description' => 'Permiso para editar cuentas de Costos']);
    }
}
