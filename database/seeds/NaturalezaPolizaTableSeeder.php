<?php

use Illuminate\Database\Seeder;

class NaturalezaPolizaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->table('Contabilidad.naturaleza_poliza')->insert(
            ['descripcion' => 'Deudora',]
        );

        DB::connection("cadeco")->table('Contabilidad.naturaleza_poliza')->insert(
            ['descripcion' => 'Acreedora',]
        );
    }
}
