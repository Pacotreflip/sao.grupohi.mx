<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TesoreriaTiposMovimientos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tesoreria Tipos de Movimientos
        DB::connection("cadeco")->table('Tesoreria.tipos_movimientos')->insert([
            'descripcion' => 'Intereses',
            'naturaleza' => 1,
            'estatus' => 1,
            'registro' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::connection("cadeco")->table('Tesoreria.tipos_movimientos')->insert([
            'descripcion' => 'Intereses Ganados',
            'naturaleza' => 1,
            'estatus' => 1,
            'registro' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::connection("cadeco")->table('Tesoreria.tipos_movimientos')->insert([
            'descripcion' => 'Pago de ISR',
            'naturaleza' => 1,
            'estatus' => 1,
            'registro' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::connection("cadeco")->table('Tesoreria.tipos_movimientos')->insert([
            'descripcion' => 'Comisiones Bancarias',
            'naturaleza' => 1,
            'estatus' => 1,
            'registro' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
