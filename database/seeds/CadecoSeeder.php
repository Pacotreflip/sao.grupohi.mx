<?php

use Illuminate\Database\Seeder;

class CadecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //dbo
        $this->call(TipoTranSeeder::class);

        //Contabilidad
        $this->call(ContabilidadDatosContablesObraSeeder::class);
        $this->call(ContabilidadEstatusPrepolizasSeeder::class);
        $this->call(ContabilidadIntTiposCuentasContablesSeeder::class);
        $this->call(ContabilidadIntTiposPolizasContpaqSeeder::class);
        $this->call(ContabilidadNaturalezaPolizaSeeder::class);
        $this->call(ContabilidadPolizaTipoSAOSeeder::class);
        $this->call(ContabilidadTiposCuentasEmpresasSeeder::class);
        $this->call(ContabilidadTiposCuentasMaterialesSeeder::class);
        $this->call(ContabilidadTiposMovimientosSeeder::class);
        $this->call(ContabilidadIntTransaccionesInterfazSeeder::class);

        //Control de Costos
        $this->call(ControlCostosEstatusSeeder::class);

        //Tesorería
        $this->call(TesoreriaTiposMovimientosSeeder::class);
    }
}
