<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusPrepolizasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('Contabilidad.estatus_prepolizas')->insert ([
            ['estatus' => -3, 'descripcion' => 'No Lanzable'],        
            ['estatus' => -2, 'descripcion' => 'No Lanzada'],
            ['estatus' => -1, 'descripcion' => 'Con Errores'],
            ['estatus' => 0, 'descripcion' => 'No Validada'],
            ['estatus' => 1, 'descripcion' => 'Validada'],
            ['estatus' => 2, 'descripcion' => 'Lanzada'],
            ['estatus' => -3, 'descripcion' => 'Omitir'],

        ]);
    }
}
