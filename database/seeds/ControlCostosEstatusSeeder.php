<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\ControlCostos\Estatus;

class ControlCostosEstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estatus::create(['estatus' => 1, 'descripcion' => 'Solicitada']);
        Estatus::create(['estatus' => 2, 'descripcion' => 'Autorizada']);
        Estatus::create(['estatus' => -1, 'descripcion' => 'Rechazada']);
    }
}
