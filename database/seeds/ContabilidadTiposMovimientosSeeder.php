<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoMovimiento;

class ContabilidadTiposMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMovimiento::create(['descripcion' => 'Cargo',]);
        TipoMovimiento::create(['descripcion' => 'Abono',]);
    }
}
