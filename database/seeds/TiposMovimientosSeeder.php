<?php

use Illuminate\Database\Seeder;

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
