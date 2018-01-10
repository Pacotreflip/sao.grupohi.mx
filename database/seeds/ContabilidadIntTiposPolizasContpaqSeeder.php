<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoPolizaContpaq;

class ContabilidadIntTiposPolizasContpaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPolizaContpaq::create(['descripcion' => 'Póliza de Ingresos']);
        TipoPolizaContpaq::create(['descripcion' => 'Póliza de Egresos']);
        TipoPolizaContpaq::create(['descripcion' => 'Póliza de Diario']);
    }
}
