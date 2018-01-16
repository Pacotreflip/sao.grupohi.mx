<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\TipoTransaccion;

class TipoTranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Requisicion Compra')
            ->where('Tipo_Transaccion','17')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '17','Descripcion' => 'Requisicion Compra','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Requisicion Compra')
                ->where('Tipo_Transaccion','=','17')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Requisicion Renta')
            ->where('Tipo_Transaccion','17')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '17','Descripcion' => 'Requisicion Renta','Opciones' => '8'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Requisicion Renta')
                ->where('Tipo_Transaccion','=','17')
                ->update(['Opciones' => '8']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Cotizacion Compra')
            ->where('Tipo_Transaccion','18')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '18','Descripcion' => 'Cotizacion Compra','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Cotizacion Compra')
                ->where('Tipo_Transaccion','=','18')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Cotizacion Renta')
            ->where('Tipo_Transaccion','18')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '18','Descripcion' => 'Cotizacion Renta','Opciones' => '8'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Cotizacion Renta')
                ->where('Tipo_Transaccion','=','18')
                ->update(['Opciones' => '8']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Orden Compra')
            ->where('Tipo_Transaccion','19')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '19','Descripcion' => 'Orden Compra','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Orden Compra')
                ->where('Tipo_Transaccion','=','19')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Orden Renta')
            ->where('Tipo_Transaccion','19')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '19','Descripcion' => 'Orden Renta','Opciones' => '8'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Orden Renta')
                ->where('Tipo_Transaccion','=','19')
                ->update(['Opciones' => '8']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Orden Compra Abierta')
            ->where('Tipo_Transaccion','19')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '19','Descripcion' => 'Orden Compra Abierta','Opciones' => '65537'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Orden Compra Abierta')
                ->where('Tipo_Transaccion','=','19')
                ->update(['Opciones' => '65537']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Entrada Materiales')
            ->where('Tipo_Transaccion','33')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '33','Descripcion' => 'Entrada Materiales','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Entrada Materiales')
                ->where('Tipo_Transaccion','=','33')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Entrada Maquinaria')
            ->where('Tipo_Transaccion','33')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '33','Descripcion' => 'Entrada Maquinaria','Opciones' => '8'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Entrada Maquinaria')
                ->where('Tipo_Transaccion','=','33')
                ->update(['Opciones' => '8']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Salidas Almacen')
            ->where('Tipo_Transaccion','34')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '34','Descripcion' => 'Salidas Almacen','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Salidas Almacen')
                ->where('Tipo_Transaccion','=','34')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Salidas Equipo')
            ->where('Tipo_Transaccion','34')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '34','Descripcion' => 'Salidas Equipo','Opciones' => '8'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Salidas Equipo')
                ->where('Tipo_Transaccion','=','34')
                ->update(['Opciones' => '8']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Salidas Transfer')
            ->where('Tipo_Transaccion','34')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '34','Descripcion' => 'Salidas Transfer','Opciones' => '65537'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Salidas Transfer')
                ->where('Tipo_Transaccion','=','34')
                ->update(['Opciones' => '65537']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Ajuste  (+)')
            ->where('Tipo_Transaccion','35')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '35','Descripcion' => 'Ajuste  (+)','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Ajuste  (+)')
                ->where('Tipo_Transaccion','=','35')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Ajuste  (-)')
            ->where('Tipo_Transaccion','35')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '35','Descripcion' => 'Ajuste  (-)','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Ajuste  (-)')
                ->where('Tipo_Transaccion','=','35')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Ajuste Nuevo Lote')
            ->where('Tipo_Transaccion','35')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '35','Descripcion' => 'Ajuste Nuevo Lote','Opciones' => '2'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Ajuste Nuevo Lote')
                ->where('Tipo_Transaccion','=','35')
                ->update(['Opciones' => '2']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Partes Uso')
            ->where('Tipo_Transaccion','36')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '36','Descripcion' => 'Partes Uso','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Partes Uso')
                ->where('Tipo_Transaccion','=','36')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Devolucion Insumos')
            ->where('Tipo_Transaccion','37')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '37','Descripcion' => 'Devolucion Insumos','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Devolucion Insumos')
                ->where('Tipo_Transaccion','=','37')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Contratos')
            ->where('Tipo_Transaccion','48')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '48','Descripcion' => 'Contratos','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Contratos')
                ->where('Tipo_Transaccion','=','48')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Contrato Proyectado')
            ->where('Tipo_Transaccion','49')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '49','Descripcion' => 'Contrato Proyectado','Opciones' => '1026'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Contrato Proyectado')
                ->where('Tipo_Transaccion','=','49')
                ->update(['Opciones' => '1026']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Cotizacion Contrato')
            ->where('Tipo_Transaccion','50')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '50','Descripcion' => 'Cotizacion Contrato','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Cotizacion Contrato')
                ->where('Tipo_Transaccion','=','50')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Subcontrato')
            ->where('Tipo_Transaccion','51')
            ->where('Opciones','0')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '51','Descripcion' => 'Subcontrato','Opciones' => '0'],
            ]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Subcontrato')
            ->where('Tipo_Transaccion','51')
            ->where('Opciones','2')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '51','Descripcion' => 'Subcontrato','Opciones' => '2'],
            ]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Tipo_Transaccion','52')->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '52','Descripcion' => 'Estimacion Subcontrato','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Tipo_Transaccion','=','52')
                ->update(['Opciones' => '0','Descripcion' => 'Estimacion Subcontrato']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Fondo Garantia')
            ->where('Tipo_Transaccion','53')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '53','Descripcion' => 'Fondo Garantia','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Fondo Garantia')
                ->where('Tipo_Transaccion','=','53')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Finanzas')
            ->where('Tipo_Transaccion','64')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '64','Descripcion' => 'Finanzas','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Finanzas')
                ->where('Tipo_Transaccion','=','64')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Facturas')
            ->where('Tipo_Transaccion','65')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '65','Descripcion' => 'Facturas','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Facturas')
                ->where('Tipo_Transaccion','=','65')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Factura Varios Materiales\Servicios')
            ->where('Tipo_Transaccion','65')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '65','Descripcion' => 'Factura Varios Materiales\Servicios','Opciones' => '65537'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Factura Varios Materiales\Servicios')
                ->where('Tipo_Transaccion','=','65')
                ->update(['Opciones' => '65537']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Factura Varios Gastos Varios')
            ->where('Tipo_Transaccion','65')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '65','Descripcion' => 'Factura Varios Gastos Varios','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Factura Varios Gastos Varios')
                ->where('Tipo_Transaccion','=','65')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Anticipos')
            ->where('Tipo_Transaccion','66')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '66','Descripcion' => 'Anticipos','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Anticipos')
                ->where('Tipo_Transaccion','=','66')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Contrarecibo')
            ->where('Tipo_Transaccion','67')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '67','Descripcion' => 'Contrarecibo','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Contrarecibo')
                ->where('Tipo_Transaccion','=','67')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Orden Pago')
            ->where('Tipo_Transaccion','68')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '68','Descripcion' => 'Orden Pago','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Orden Pago')
                ->where('Tipo_Transaccion','=','68')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Nota Credito')
            ->where('Tipo_Transaccion','69')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '69','Descripcion' => 'Nota Credito','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Nota Credito')
                ->where('Tipo_Transaccion','=','69')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Aplicacion Manual')
            ->where('Tipo_Transaccion','70')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '70','Descripcion' => 'Aplicacion Manual','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Aplicacion Manual')
                ->where('Tipo_Transaccion','=','70')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Reposicion Fondo F')
            ->where('Tipo_Transaccion','72')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '72','Descripcion' => 'Reposicion Fondo F','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Reposicion Fondo F')
                ->where('Tipo_Transaccion','=','72')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Pagos a Cuenta')
            ->where('Tipo_Transaccion','72')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '72','Descripcion' => 'Pagos a Cuenta','Opciones' => '327681'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pagos a Cuenta')
                ->where('Tipo_Transaccion','=','72')
                ->update(['Opciones' => '327681']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Anticipos y Destajos')
            ->where('Tipo_Transaccion','72')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '72','Descripcion' => 'Anticipos y Destajos','Opciones' => '131073'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Anticipos y Destajos')
                ->where('Tipo_Transaccion','=','72')
                ->update(['Opciones' => '131073']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Pago Lista de Raya')
            ->where('Tipo_Transaccion','72')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '72','Descripcion' => 'Pago Lista de Raya','Opciones' => '65537'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pago Lista de Raya')
                ->where('Tipo_Transaccion','=','72')
                ->update(['Opciones' => '65537']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Bancos')
            ->where('Tipo_Transaccion','80')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '80','Descripcion' => 'Bancos','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Bancos')
                ->where('Tipo_Transaccion','=','80')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Depositos')
            ->where('Tipo_Transaccion','81')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '81','Descripcion' => 'Depositos','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Depositos')
                ->where('Tipo_Transaccion','=','81')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Pagos')
            ->where('Tipo_Transaccion','82')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '82','Descripcion' => 'Pagos','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pagos')
                ->where('Tipo_Transaccion','=','82')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Pagos Varios')
            ->where('Tipo_Transaccion','82')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '82','Descripcion' => 'Pagos Varios','Opciones' => '1'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pagos Varios')
                ->where('Tipo_Transaccion','=','82')
                ->update(['Opciones' => '1']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Pagos a Cuenta')
            ->where('Tipo_Transaccion','82')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '82','Descripcion' => 'Pagos a Cuenta','Opciones' => '327681'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pagos a Cuenta')
                ->where('Tipo_Transaccion','=','82')
                ->update(['Opciones' => '327681']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Credito')
            ->where('Tipo_Transaccion','83')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '83','Descripcion' => 'Credito','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Credito')
                ->where('Tipo_Transaccion','=','83')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Debito')
            ->where('Tipo_Transaccion','84')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '84','Descripcion' => 'Debito','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Debito')
                ->where('Tipo_Transaccion','=','84')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Concepto')
            ->where('Tipo_Transaccion','96')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '96','Descripcion' => 'Concepto','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Concepto')
                ->where('Tipo_Transaccion','=','96')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Transferencia')
            ->where('Tipo_Transaccion','97')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '97','Descripcion' => 'Transferencia','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Transferencia')
                ->where('Tipo_Transaccion','=','97')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Avance Obra')
            ->where('Tipo_Transaccion','98')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '98','Descripcion' => 'Avance Obra','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Avance Obra')
                ->where('Tipo_Transaccion','=','98')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Lista Raya')
            ->where('Tipo_Transaccion','99')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '99','Descripcion' => 'Lista Raya','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Lista Raya')
                ->where('Tipo_Transaccion','=','99')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Lista Asistencia')
            ->where('Tipo_Transaccion','100')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '100','Descripcion' => 'Lista Asistencia','Opciones' => NULL],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Lista Asistencia')
                ->where('Tipo_Transaccion','=','100')
                ->update(['Opciones' => NULL]);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Fondo Fijo')
            ->where('Tipo_Transaccion','101')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '101','Descripcion' => 'Fondo Fijo','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Fondo Fijo')
                ->where('Tipo_Transaccion','=','101')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Prestaciones')
            ->where('Tipo_Transaccion','102')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '102','Descripcion' => 'Prestaciones','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Prestaciones')
                ->where('Tipo_Transaccion','=','102')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Estimacion Obras')
            ->where('Tipo_Transaccion','103')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '103','Descripcion' => 'Estimacion Obras','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Estimacion Obras')
                ->where('Tipo_Transaccion','=','103')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Conf. de Cobranza')
            ->where('Tipo_Transaccion','104')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '104','Descripcion' => 'Conf. de Cobranza','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Conf. de Cobranza')
                ->where('Tipo_Transaccion','=','104')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Avance Subcontratos')
            ->where('Tipo_Transaccion','105')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '105','Descripcion' => 'Avance Subcontratos','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Avance Subcontratos')
                ->where('Tipo_Transaccion','=','105')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Propuesta Tecnica')
            ->where('Tipo_Transaccion','106')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '106','Descripcion' => 'Propuesta Tecnica','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Propuesta Tecnica')
                ->where('Tipo_Transaccion','=','106')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Propuesta Economica')
            ->where('Tipo_Transaccion','107')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '107','Descripcion' => 'Propuesta Economica','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Propuesta Economica')
                ->where('Tipo_Transaccion','=','107')
                ->update(['Opciones' => '0']);
        }

        $find  = \Ghi\Domain\Core\Models\TipoTransaccion::where('Descripcion', 'Confirm. Propuesta')
            ->where('Tipo_Transaccion','108')
            ->first();
        if($find == null){
            DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
                ['Tipo_Transaccion' => '108','Descripcion' => 'Confirm. Propuesta','Opciones' => '0'],
            ]);
        }else{
            DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Confirm. Propuesta')
                ->where('Tipo_Transaccion','=','108')
                ->update(['Opciones' => '0']);
        }
    }
}
