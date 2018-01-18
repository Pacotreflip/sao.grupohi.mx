<?php

use Illuminate\Database\Seeder;

class ControlPresupuestoBasesPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('cadeco')->table('ControlPresupuesto.bases_presupuesto')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('ControlPresupuesto.bases_presupuesto',RESEED, 0)");

        // Naturaleza 2 tipo transaccion 84
       \Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto::create([
            'descripcion' => 'CLIENTE',
            'base_datos' => 'SAO1814_TERMINAL_NAICM_WBS_CLIENTE'
        ]);
        // Naturaleza 2 tipo transaccion 84
        \Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto::create([
            'descripcion' => 'CONTROL',
            'base_datos' => 'SAO1814_TERMINAL_NAICM'
        ]);
        // Naturaleza 2 tipo transaccion 84
        \Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto::create([
            'descripcion' => 'PROFORMA',
            'base_datos' => 'SAO1814_TERMINAL_NAICM_PRO_WBS'
        ]);


    }
}
