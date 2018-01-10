<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;

class ContabilidadTiposCuentasEmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCuentaEmpresa::create(['descripcion' => 'Cuenta de Proveedor / Acreedor', 'id_tipo_cuenta_contable' => 2]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta Proveedor USD', 'id_tipo_cuenta_contable' => 27]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta Proveedor Comp.', 'id_tipo_cuenta_contable' => 28]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta de Anticipo a Proveedores', 'id_tipo_cuenta_contable' => 12]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta Anticipo USD', 'id_tipo_cuenta_contable' => 31]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta Anticipo Comp.', 'id_tipo_cuenta_contable' => 32]);
        TipoCuentaEmpresa::create(['descripcion' => 'Cta de Fondo de Garantía', 'id_tipo_cuenta_contable' => 10]);
    }
}
