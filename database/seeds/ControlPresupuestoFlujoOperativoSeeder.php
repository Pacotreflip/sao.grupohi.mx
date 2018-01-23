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

        DB::connection('cadeco')->table('ControlPresupuesto.tipo_cobrabilidad')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('ControlPresupuesto.tipo_cobrabilidad',RESEED, 0)");
        DB::connection('cadeco')->table('ControlPresupuesto.tipos_ordenes')->delete();
        DB::connection("cadeco")->statement("DBCC CHECKIDENT ('ControlPresupuesto.tipos_ordenes',RESEED, 0)");

        $cobrables=\Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad::create([
            'descripcion' => 'Cobrables',
            'estatus' => 1
        ]);
        $NoCobrables=\Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad::create([
            'descripcion' => 'No Cobrables',
            'estatus' => 1
        ]);

        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Escalatorias (Ajuste de Costos)',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Reclamos de Indirecto',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Conceptos Extraordinarios',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Variación de Volumen (Aditivas o Deductivas)',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1
        ]);

        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio no Cobrables',
            'id_tipo_cobrabilidad'=>$NoCobrables->id,
            'estatus' => 1
        ]);
        \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio de Insumos',
            'id_tipo_cobrabilidad'=>$NoCobrables->id,
            'estatus' => 1
        ]);
    }
}
