<?php

use Illuminate\Database\Seeder;

class NuevosSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Flujo Operativo solicitud cambios al presupuesto
        $this->call(ControlPresupuestoFlujoOperativoSeeder::class);
        //Flujo Operativo solicitud cambios al presupuesto
        $this->call(ControlPresupuestoEstatusSeeder::class);

        $this->call(ControlPresupuestoTarjetasSeeder::class);
    }
}
