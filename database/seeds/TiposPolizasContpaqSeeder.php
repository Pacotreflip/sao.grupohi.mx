<?php

use Illuminate\Database\Seeder;

class TiposPolizasContpaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->table('Contabilidad.int_tipos_polizas_contpaq')->insert(
            ['descripcion' => 'Póliza de Ingresos',]
        );
        DB::connection("cadeco")->table('Contabilidad.int_tipos_polizas_contpaq')->insert(
            ['descripcion' => 'Póliza de Egresos',]
        );
        DB::connection("cadeco")->table('Contabilidad.int_tipos_polizas_contpaq')->insert(
            ['descripcion' => 'Póliza de Diario',]
        );
    }
}
