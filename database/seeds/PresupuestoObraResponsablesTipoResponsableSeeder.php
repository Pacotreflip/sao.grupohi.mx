<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\PresupuestoObra\ResponsablesTipo;

class PresupuestoObraResponsablesTipoResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregar tipo 3 Responsable
        ResponsablesTipo::create([
            'descripcion' => 'Responsable'
        ]);
    }
}
