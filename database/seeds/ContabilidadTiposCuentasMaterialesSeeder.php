<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaMaterial;

class ContabilidadTiposCuentasMaterialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_materiales')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('Contabilidad.tipos_cuentas_materiales',RESEED, 0)");
        TipoCuentaMaterial::create(['descripcion' => 'Cuenta de Inventario']);
        TipoCuentaMaterial::create(['descripcion' => 'Cuenta de Costo']);
    }
}