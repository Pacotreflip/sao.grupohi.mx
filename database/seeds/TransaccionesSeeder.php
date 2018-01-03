<?php

use Illuminate\Database\Seeder;

class TransaccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Contrato Proyectado')
            ->update(['Opciones' => '1026']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Cotizacion Contrato')
            ->update(['Opciones' => '0']);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '51'],
            ['descripcion' => 'Subcontrato'],
            ['Opciones' => '2']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Tipo_Transaccion', '=', '52')
            ->update(['descripcion' => 'Estimacion Subcontrato']);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '65'],
            ['descripcion' => 'Factura Varios Materiales\Servicios'],
            ['Opciones' => '65537']
        ]);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '65'],
            ['descripcion' => 'Factura Varios Gastos Varios'],
            ['Opciones' => '1']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Tipo_Transaccion', '=', '81')
            ->update(['Opciones' => '1']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('descripcion', '=', 'Pagos')
            ->update(['Opciones' => '0']);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '82'],
            ['descripcion' => ' Pagos Varios'],
            ['Opciones' => '1']
        ]);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '82'],
            ['descripcion' => 'Pagos a Cuenta'],
            ['Opciones' => '327681']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('descripcion', '=', 'Credito')->where('Tipo_Transaccion','=','83')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('descripcion', '=', 'Debito')->where('Tipo_Transaccion','=','84')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('descripcion', '=', 'Fondo Fijo')->where('Tipo_Transaccion','=','101')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('descripcion', '=', 'Estimacion Obras')->where('Tipo_Transaccion','=','103')
            ->update(['Opciones' => '0']);
    }
}
