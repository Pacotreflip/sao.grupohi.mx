<?php

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TiposMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->table('Contabilidad.tipos_movimientos')->insert(
            ['descripcion' => 'Cargo',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_movimientos')->insert(
            ['descripcion' => 'Abono',]
        );
    }
}
