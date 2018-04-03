<?php

use Illuminate\Database\Seeder;
use   \Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro;

class ControlPresupuestoTipoFiltroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFiltro::create([
            'id' => '1',
            'descripcion' => 'Sector'
        ]);
        TipoFiltro::create([
            'id' => '2',
            'descripcion' => 'Cuadrante'
        ]);
        TipoFiltro::create([
            'id' => '3',
            'descripcion' => 'Tarjeta'
        ]);

    }
}
