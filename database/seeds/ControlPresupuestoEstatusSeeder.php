<?php

use Illuminate\Database\Seeder;
use   \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;

class ControlPresupuestoEstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estatus::create([
            'clave_estado' => '1',
            'descripcion' => 'Generada'
        ]);
        Estatus::create([
            'clave_estado' => '2',
            'descripcion' => 'Autorizada'
        ]);
        Estatus::create([
            'clave_estado' => '3',
            'descripcion' => 'Rechazada'
        ]);

    }
}
