<?php

use Illuminate\Database\Seeder;

class PermisosTraspasoCuentas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'eliminar_traspaso_cuenta', 'display_name' => 'Eliminar Traspasos entre cuentas', 'description' => 'Permiso para eliminar traspasos entre cuentas']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'registrar_traspaso_cuenta', 'display_name' => 'Registrar Traspasos entre cuentas', 'description' => 'Permiso para registrar un traspaso entre cuentas']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_traspaso_cuenta', 'display_name' => 'Consultar Traspasos entre cuentas', 'description' => 'Permiso para consultar la lista de traspasos entre cuentas']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'editar_traspaso_cuenta', 'display_name' => 'Editar Traspasos entre cuentas', 'description' => 'Permiso para editar la lista de traspasos entre cuentas']);
    }
}
