<?php

use Illuminate\Database\Seeder;

class PermisosCuentasFondosAsignacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editar_cuenta_fondo    = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'editar_cuenta_fondo')->first();
        $registrar_cuenta_fondo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'registrar_cuenta_fondo')->first();
        $consultar_cuenta_fondo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'consultar_cuenta_fondo')->first();

        $contador  = \Ghi\Domain\Core\Models\Seguridad\Role::where('name', 'Contador')->first();
        $consultar = \Ghi\Domain\Core\Models\Seguridad\Role::where('name', 'Consultar')->first();

        $contador->attachPermissions([$editar_cuenta_fondo, $registrar_cuenta_fondo, $consultar_cuenta_fondo]);
        $consultar->attachPermission($consultar_cuenta_fondo);
    }
}
