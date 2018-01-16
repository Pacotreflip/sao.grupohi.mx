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
        DB::connection('cadeco')->table('Contabilidad.datos_contables_obra')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('Contabilidad.datos_contables_obra',RESEED, 0)");
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
