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
        //Inserts
        TipoTransaccion::firstOrCreate(['Tipo_Transaccion' => '65', 'Descripcion' => 'Factura Varios Materiales\Servicios','Opciones' => '65537']);
        TipoTransaccion::firstOrCreate(['Tipo_Transaccion' => '65','Descripcion' => 'Factura Varios Gastos Varios','Opciones' => '1']);
        TipoTransaccion::firstOrCreate(['Tipo_Transaccion' => '51','Descripcion' => 'Subcontrato','Opciones' => '2']);
        TipoTransaccion::firstOrCreate(['Tipo_Transaccion' => '82', 'Descripcion' => ' Pagos Varios','Opciones' => '1']);
        TipoTransaccion::firstOrCreate(['Tipo_Transaccion' => '82','Descripcion' => 'Pagos a Cuenta','Opciones' => '327681']);

        //Updates
        TipoTransaccion::where('Descripcion', '=', 'Contrato Proyectado')->update(['Opciones' => '1026']);
        TipoTransaccion::where('Descripcion', '=', 'Cotizacion Contrato')->update(['Opciones' => '0']);
        TipoTransaccion::where('Tipo_Transaccion', '=', '52')->update(['Descripcion' => 'Estimacion Subcontrato']);
        TipoTransaccion::where('Tipo_Transaccion', '=', '81')->update(['Opciones' => '1']);
        TipoTransaccion::where('Descripcion', '=', 'Pagos')->update(['Opciones' => '0']);
        TipoTransaccion::where('Descripcion', '=', 'Credito')->where('Tipo_Transaccion','=','83')->update(['Opciones' => '0']);
        TipoTransaccion::where('Descripcion', '=', 'Debito')->where('Tipo_Transaccion','=','84')->update(['Opciones' => '0']);
        TipoTransaccion::where('Descripcion', '=', 'Fondo Fijo')->where('Tipo_Transaccion','=','101')->update(['Opciones' => '0']);
        TipoTransaccion::where('Descripcion', '=', 'Estimacion Obras')->where('Tipo_Transaccion','=','103')->update(['Opciones' => '0']);
    }
}
