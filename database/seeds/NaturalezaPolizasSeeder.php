<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NaturalezaPolizasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("cadeco")->statement("SET IDENTITY_INSERT Contabilidad.naturaleza_poliza ON;
            SET IDENTITY_INSERT Contabilidad.naturaleza_poliza ON;
            insert into Contabilidad.naturaleza_poliza (id_naturaleza_poliza, descripcion) values (1, 'Deudora');
            insert into Contabilidad.naturaleza_poliza (id_naturaleza_poliza, descripcion) values (2, 'Acreedora');,
        
        ");
    }
}
