<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\NaturalezaPoliza;

class ContabilidadNaturalezaPolizaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement("
        SET IDENTITY_INSERT Contabilidad.naturaleza_poliza ON;
            insert into Contabilidad.naturaleza_poliza(id_naturaleza_poliza, descripcion) values(1,'Deudora');
            insert into Contabilidad.naturaleza_poliza(id_naturaleza_poliza, descripcion) values(2,'Acreedora');
        SET IDENTITY_INSERT Contabilidad.naturaleza_poliza OFF;
        ");
    }
}
