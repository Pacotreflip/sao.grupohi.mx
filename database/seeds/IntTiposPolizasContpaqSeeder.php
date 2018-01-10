<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntTiposPolizasContpaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection('cadeco')->table('Contabilidad.int_tipos_polizas_contpaq')->delete();

        DB::connection('cadeco')->table('Contabilidad.int_tipos_polizas_contpaq')->insert ([
            ['descripcion' => 'Póliza de Ingresos'],
            ['descripcion' => 'Póliza de Egresos'],
            ['descripcion' => 'Póliza de Diario'],
        ]);
    }
}
