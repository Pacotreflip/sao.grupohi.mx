<?php

use Illuminate\Database\Seeder;

class PermisoCuentasCostosAsignacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editar_cuenta_costo    = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'editar_cuenta_costo')->first();
        $registrar_cuenta_costo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'registrar_cuenta_costo')->first();
        $consultar_cuenta_costo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'consultar_cuenta_costo')->first();
        $eliminar_cuenta_costo = \Ghi\Domain\Core\Models\Seguridad\Permission::where('name', 'eliminar_cuenta_costo')->first();

        $contador  = \Ghi\Domain\Core\Models\Seguridad\Role::where('name', 'Contador')->first();

        $contador->attachPermissions([$editar_cuenta_costo, $registrar_cuenta_costo, $consultar_cuenta_costo, $eliminar_cuenta_costo]);
    }
}
