<?php

use Illuminate\Database\Seeder;

class ControlPresupuestoFlujoOperativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cobrables = \Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad::firstorcreate([
            'descripcion' => 'Cobrables',
            'estatus' => 1,
            'id' => 1
        ]);
        $NoCobrables = \Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad::create([
            'descripcion' => 'No Cobrables',
            'estatus' => 1,
            'id' => 2
        ]);

        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Escalatorias (Ajuste de Costos)',
            'id_tipo_cobrabilidad' => $cobrables->id,
            'estatus' => 1,
            'name' => 'escalatoria',
            'id' => 1
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Reclamos de Indirecto',
            'id_tipo_cobrabilidad' => $cobrables->id,
            'estatus' => 1,
            'name' => 'reclamos_indirecto',
            'id' => 2
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Conceptos Extraordinarios',
            'id_tipo_cobrabilidad' => $cobrables->id,
            'estatus' => 1,
            'name' => 'conceptos_extraordinarios',
            'id' => 3
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Variación de Volumen (Aditivas o Deductivas)',
            'id_tipo_cobrabilidad' => $cobrables->id,
            'estatus' => 1,
            'name' => 'variacion_volumen',
            'id' => 4
        ]);

        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio no Cobrables',
            'id_tipo_cobrabilidad' => $NoCobrables->id,
            'estatus' => 1,
            'name' => 'cambio_no_cobrables',
            'id' => 5
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio de Insumos (Costo Directo)',
            'id_tipo_cobrabilidad' => $NoCobrables->id,
            'estatus' => 1,
            'name' => 'cambio_insumos',
            'id' => 6
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio de Insumos (Costo Indirecto)',
            'id_tipo_cobrabilidad' => $NoCobrables->id,
            'estatus' => 1,
            'name' => 'cambio_insumos_indirecto',
            'id' => 7
        ]);
    }
}

