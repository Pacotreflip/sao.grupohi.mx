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
            ['Descripcion' => 'Subcontrato'],
            ['Opciones' => '2']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Tipo_Transaccion', '=', '52')
            ->update(['Descripcion' => 'Estimacion Subcontrato']);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '65'],
            ['Descripcion' => 'Factura Varios Materiales\Servicios'],
            ['Opciones' => '65537']
        ]);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '65'],
            ['Descripcion' => 'Factura Varios Gastos Varios'],
            ['Opciones' => '1']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Tipo_Transaccion', '=', '81')
            ->update(['Opciones' => '1']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Pagos')
            ->update(['Opciones' => '0']);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '82'],
            ['Descripcion' => ' Pagos Varios'],
            ['Opciones' => '1']
        ]);

        DB::connection('cadeco')->table('dbo.TipoTran')->insert ([
            ['Tipo_Transaccion' => '82'],
            ['Descripcion' => 'Pagos a Cuenta'],
            ['Opciones' => '327681']
        ]);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Credito')->where('Tipo_Transaccion','=','83')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Debito')->where('Tipo_Transaccion','=','84')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Fondo Fijo')->where('Tipo_Transaccion','=','101')
            ->update(['Opciones' => '0']);

        DB::connection("cadeco")->table('dbo.TipoTran')->where('Descripcion', '=', 'Estimacion Obras')->where('Tipo_Transaccion','=','103')
            ->update(['Opciones' => '0']);
    }
}
