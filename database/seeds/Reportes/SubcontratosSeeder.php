<?php

use Illuminate\Database\Seeder;

class SubcontratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jefe_subcontratos = \Ghi\Domain\Core\Models\Seguridad\Role::create([
            'name' => 'jefe_subcontratos',
            'description' => 'Jefe de Subcontratos',
            'display_name' => 'Jefe de Subcontratos'
        ]);

        $jefe_procuracion = \Ghi\Domain\Core\Models\Seguridad\Role::create([
            'name' => 'jefe_procuracion',
            'description' => 'Jefe de Procuración',
            'display_name' => 'Jefe de Procuración'
        ]);

        $consultar_reporte_estimacion = \Ghi\Domain\Core\Models\Seguridad\Permission::create([
            'name' => 'consultar_reporte_estimacion',
            'description' => 'Consultar Solicitudes de Orden de Pago Estimación',
            'display_name' => 'Consultar Solicitudes de Orden de Pago Estimación'
        ]);

        $jefe_procuracion->attachPermission($consultar_reporte_estimacion);
        $jefe_subcontratos->attachPermission($consultar_reporte_estimacion);
    }
}
