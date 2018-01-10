<?php

use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Contabilidad\DatosContables;
use Illuminate\Database\Seeder;

class ContabilidadDatosContablesObraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Obra::all() as $obra) {
            DatosContables::create([
               'id_obra' => $obra->id_obra,
               'BDContPaq' => null,
               'NumobraContPaq' => null,
               'FormatoCuenta' => null,
               'FormatoCuentaRegExp' => null
            ]);
        }
    }
}
