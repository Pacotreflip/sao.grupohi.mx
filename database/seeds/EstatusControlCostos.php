<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EstatusControlCostos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Solicitada
        DB::connection("cadeco")->table('ControlCostos.estatus')->insert([
            'estatus' => 1,
            'descripcion' => 'Solicitada',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // Autorizada
        DB::connection("cadeco")->table('ControlCostos.estatus')->insert([
            'estatus' => 2,
            'descripcion' => 'Autorizada',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // Rechazada
        DB::connection("cadeco")->table('ControlCostos.estatus')->insert([
            'estatus' => -1,
            'descripcion' => 'Rechazada',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
