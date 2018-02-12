<?php

use Illuminate\Database\Seeder;

class ControlPresupuestoAfectacionOrdenesPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variacion_volumen = \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::find(4);
        $escalatoria = \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::find(1);

        $variacion_volumen->basesPresupuesto()->attach([1,2,3]);
        $escalatoria->basesPresupuesto()->attach([1]);
    }
}
