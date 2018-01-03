<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposCuentasMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_materiales')->delete();

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_materiales')->insert ([
            ['descripcion' => 'Cuenta de Inventario'],
            ['descripcion' => 'Cuenta de Costo'],
        ]);
    }
}
