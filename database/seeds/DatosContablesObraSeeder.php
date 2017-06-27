<?php

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosContablesObraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Obra::all() as $obra) {
           DB::connection('cadeco')->table('Contabilidad.datos_contables_obra')->insert([
               'id_obra' => $obra->id_obra,
               'BDContPaq' => null,
               'NumobraContPaq' => null,
               'FormatoCuenta' => null,
               'FormatoCuentaRegExp' => null,
               'created_at' => DB::raw('CURRENT_TIMESTAMP')
           ]);
        }
    }
}
