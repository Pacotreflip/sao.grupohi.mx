<?php

use Illuminate\Database\Seeder;

class TiposSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Finanzas\CTGTipoSolicitud::create(['descripcion' => 'Programada', 'descripcion_corta' => 'PR']);
        \Ghi\Domain\Core\Models\Finanzas\CTGTipoSolicitud::create(['descripcion' => 'Urgente', 'descripcion_corta' => 'UR']);
    }
}
