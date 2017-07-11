<?php

use Illuminate\Database\Seeder;

class TiposCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*TIPOS CUENTAS EMPRESAS*/
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Proveedor',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Proveedor USD',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Proveedor Complementaria',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Anticipo a Proveedor',]
        );
        
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Subcontratista',]
        );
        
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Subcontratista USD',]
        );
        
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Subcontratista Complementaria',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Fondo de Garantía',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_empresas')->insert(
            ['descripcion' => 'Cuenta de Anticipo a Subcontratista',]
        );
        /*TIPOS CUENTAS MATERIALES*/
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_materiales')->insert(
            ['descripcion' => 'Cuenta de Inventario',]
        );
        DB::connection("cadeco")->table('Contabilidad.tipos_cuentas_materiales')->insert(
            ['descripcion' => 'Cuenta de Costo',]
        );
    }
}
