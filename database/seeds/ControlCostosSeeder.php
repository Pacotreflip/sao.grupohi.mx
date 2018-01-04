<?php

use Illuminate\Database\Seeder;

class ControlCostosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $rol = \Ghi\Domain\Core\Models\Seguridad\Role::create(['name' => 'control_proyecto', 'display_name' => 'Control de Proyecto', 'description' => 'Rol de usuario de Control de Proyecto']);
        $s_recla = \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'solicitar_reclasificacion', 'display_name' => 'Solicitar Reclasificación', 'description' => 'Permiso para Solicitar Reclasificación de Costo']);
        $a_recla = \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'autorizar_reclasificacion', 'display_name' => 'Autorizar Reclasificación', 'description' => 'Permiso para Autorizar Reclasificación de Costo']);
        $c_recla = \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_reclasificacion', 'display_name' => 'Consultar Reclasificación', 'description' => 'Permiso para Consultar Reclasificación de Costo']);

        $rol->attachPermissions([$s_recla, $a_recla, $c_recla]);
    }
}
