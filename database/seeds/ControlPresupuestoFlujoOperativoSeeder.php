<?php

use Illuminate\Database\Seeder;
use \Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad;
use \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
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
        DB::connection('cadeco')->table('ControlPresupuesto.tipos_ordenes')->delete();

        $cobrables=TipoCobrabilidad::create([
            'descripcion' => 'Cobrables',
            'estatus' => 1,
            'id'=>1
        ]);
        $NoCobrables=TipoCobrabilidad::create([
            'descripcion' => 'No Cobrables',
            'estatus' => 1,
             'id'=>2
        ]);
        $otras=TipoCobrabilidad::create([
            'descripcion' => 'Otras',
            'estatus' => 1,
            'id'=>3
        ]);

        TipoOrden::create([
            'descripcion' => 'Escalatorias (Ajuste de Costos)',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1,
            'id'=>1
        ]);
       TipoOrden::create([
            'descripcion' => 'Reclamos de Indirecto',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1,
            'id'=>2
        ]);
       TipoOrden::create([
            'descripcion' => 'Conceptos Extraordinarios',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1,
            'id'=>3
        ]);
       TipoOrden::create([
            'descripcion' => 'Variación de Volumen (Aditivas o Deductivas)',
            'id_tipo_cobrabilidad'=>$cobrables->id,
            'estatus' => 1,
            'id'=>4
        ]);

      TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio no Cobrables',
            'id_tipo_cobrabilidad'=>$NoCobrables->id,
            'estatus' => 1,
            'id'=>5
        ]);
       TipoOrden::create([
            'descripcion' => 'Ordenes de Cambio de Insumos',
            'id_tipo_cobrabilidad'=>$NoCobrables->id,
            'estatus' => 1,
            'id'=>6
        ]);
    }
}

