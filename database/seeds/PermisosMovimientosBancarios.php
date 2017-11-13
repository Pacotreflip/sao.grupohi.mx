<?php

use Illuminate\Database\Seeder;

class PermisosMovimientosBancarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'eliminar_movimiento_bancario', 'display_name' => 'Eliminar Movimientos Bancarios', 'description' => 'Permiso para eliminar Movimientos Bancarios']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'registrar_movimiento_bancario', 'display_name' => 'Registrar Movimientos Bancarios', 'description' => 'Permiso para registrar un movimiento bancario']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_movimiento_bancario', 'display_name' => 'Consultar Movimientos Bancarios', 'description' => 'Permiso para consultar la lista de Movimientos Bancarios']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'editar_movimiento_bancario', 'display_name' => 'Editar Movimientos Bancarios', 'description' => 'Permiso para editar la lista de Movimientos Bancarios']);
    }
}
