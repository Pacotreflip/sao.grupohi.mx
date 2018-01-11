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
        DB::connection('cadeco')->table('Contabilidad.tipos_movimientos')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('Contabilidad.tipos_movimientos',RESEED, 0)");
        TipoMovimiento::create(['descripcion' => 'Cargo',]);
        TipoMovimiento::create(['descripcion' => 'Abono',]);
    }
}
