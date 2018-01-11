<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Tesoreria\TipoMovimiento;

class TesoreriaTiposMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('Tesoreria.tipos_movimientos')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('Tesoreria.tipos_movimientos',RESEED, 0)");

        // Naturaleza 2 tipo transaccion 84
        TipoMovimiento::create([
            'descripcion' => 'Intereses',
            'naturaleza' => 2,
            'estatus' => 1,
            'registro' => 1
        ]);

        // Naturaleza 1 tipo transaccion 83
        TipoMovimiento::create([
            'descripcion' => 'Intereses Ganados',
            'naturaleza' => 1,
            'estatus' => 1,
            'registro' => 1
        ]);

        // Naturaleza 2 tipo transaccion 84
        TipoMovimiento::create([
            'descripcion' => 'Pago de ISR',
            'naturaleza' => 2,
            'estatus' => 1,
            'registro' => 1
        ]);

        // Naturaleza 2 tipo transaccion 84
        TipoMovimiento::create([
            'descripcion' => 'Comisiones Bancarias',
            'naturaleza' => 2,
            'estatus' => 1,
            'registro' => 1
        ]);
    }
}
