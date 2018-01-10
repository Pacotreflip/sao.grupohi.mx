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
        TipoCuentaMaterial::create(['descripcion' => 'Cuenta de Inventario']);
        TipoCuentaMaterial::create(['descripcion' => 'Cuenta de Costo']);
    }
}