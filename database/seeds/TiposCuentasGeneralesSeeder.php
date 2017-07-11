<?php

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TiposCuentasGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // foreach(Obra::all() as $obra) {
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cuenta de Costo','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cuenta de Proveedor / Acreedor','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Acreditable No Pagado 15%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Acreditable Pagado 15%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Acreditable Pagado 10%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de ISR Retenido','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Retenido','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Retención del 4%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Impuesto Cedular','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Fondo de Garantía','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Anticipo a Contratistas','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Anticipo a Proveedores','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Pasivo de Materiales','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Costo de Materiales','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Banco','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Pasivo de Subcontratos','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Pasivo de Obra','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Pasivo de Renta de Maquinaria','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Costo de Subcontratos','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Costo de Renta de Maquinaria','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Provisión de Costo de Mano de Obra','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Obras y Oficinas','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Acreditable No Pagado 16%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de IVA Acreditable Pagado 16%','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta de Inventario Materiales','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Costo Materiales','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Proveedor USD','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Proveedor Comp.','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Almacen','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Contratista','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Contrtatista USD','id_obra'=>1]
            );
            DB::connection("cadeco")->table('Contabilidad.int_tipos_cuentas_contables')->insert(
                ['descripcion' => 'Cta Contratista Comp.','id_obra'=>1]
            );
       // }
    }
}
