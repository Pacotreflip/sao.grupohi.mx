<?php

use Illuminate\Database\Seeder;

class TiposCuentasEmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 1)
            ->update(['descripcion' => 'Cuenta de Proveedor / Acreedor', 'id_tipo_cuenta_contable' => 2]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 2)
            ->update(['descripcion' => 'Cta Proveedor USD', 'id_tipo_cuenta_contable' => 27]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 3)
            ->update(['descripcion' => 'Cta Proveedor Comp.', 'id_tipo_cuenta_contable' => 28]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 4)
            ->update(['descripcion' => 'Cta de Anticipo a Proveedores', 'id_tipo_cuenta_contable' => 12]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 5)
            ->update(['deleted_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 6)
            ->update(['descripcion' => 'Cta Anticipo USD', 'id_tipo_cuenta_contable' => 31]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 7)
            ->update(['descripcion' => 'Cta Anticipo Comp.', 'id_tipo_cuenta_contable' => 32]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 8)
            ->update(['descripcion' => 'Cta de Fondo de Garantía', 'id_tipo_cuenta_contable' => 10]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 9)
            ->update(['deleted_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 10)
            ->update(['descripcion' => 'Cta otras retenciones de subcontratos', 'id_tipo_cuenta_contable' => 37]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 11)
            ->update(['descripcion' => 'Cta Fondo Garantía USD', 'id_tipo_cuenta_contable' => 38]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 12)
            ->update(['descripcion' => 'Cta Fondo Garantía Comp', 'id_tipo_cuenta_contable' => 39]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 13)
            ->update(['descripcion' => 'Cta Otras Retenciones Subcontratos USD', 'id_tipo_cuenta_contable' => 40]);

        DB::connection('cadeco')->table('Contabilidad.tipos_cuentas_empresas')
            ->where('id', '=', 14)
            ->update(['descripcion' => 'Cta Otras Retenciones Subcontratos Comp.', 'id_tipo_cuenta_contable' => 41]);
    }
}