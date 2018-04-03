<?php

use Illuminate\Database\Seeder;

class ControlProyectosCambiosAutorizadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('ControlProyectos.cambios_autorizados')->insert ([
            ['id_moneda' => '2','cambio' => 21.00],
        ]);
        DB::connection('cadeco')->table('ControlProyectos.cambios_autorizados')->insert ([
            ['id_moneda' => '3','cambio' => 23.50],
        ]);
    }

}
