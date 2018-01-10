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
        NaturalezaPoliza::create(['descripcion' => 'Deudora']);
        NaturalezaPoliza::create(['descripcion' => 'Acreedora']);
    }
}
