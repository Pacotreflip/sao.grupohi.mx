<?php
ini_set('memory_limit', '-1');
use Illuminate\Database\Seeder;

class ControlPresupuestoTarjetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            DB::connection("cadeco")->statement("DBCC CHECKIDENT ('ControlPresupuesto.tarjeta',RESEED, 0)");
            DB::connection('cadeco')->table('ControlPresupuesto.tarjeta')->delete();
            DB::connection("cadeco")->statement("DBCC CHECKIDENT ('ControlPresupuesto.concepto_tarjeta',RESEED, 0)");
            DB::connection('cadeco')->table('ControlPresupuesto.concepto_tarjeta')->delete();

            $obras = \Illuminate\Support\Facades\DB::connection('cadeco')->select("select id_obra from dbo.obras");
            foreach ($obras as $obra) {
                $conceptos = \Illuminate\Support\Facades\DB::connection('cadeco')->select("SELECT REPLACE(SUBSTRING(filtro9,1,CHARINDEX(' -',filtro9)),' ','') as tarjeta,id_concepto from [PresupuestoObra].[conceptosPath] where filtro9 like '% -%' and id_obra=" . $obra->id_obra . " order by nivel;");
                foreach ($conceptos as $conceptoPath) {
                    $tarjeta = \Illuminate\Support\Facades\DB::connection('cadeco')->select("select id from ControlPresupuesto.tarjeta where id_obra=" . $obra->id_obra . " and descripcion='" . $conceptoPath->tarjeta . "'");
                    if (count($tarjeta) == 0) { ///insertar
                        $tarjeta = \Illuminate\Support\Facades\DB::connection('cadeco')->table('ControlPresupuesto.tarjeta')->insert([
                            ['descripcion' => $conceptoPath->tarjeta, 'id_obra' => $obra->id_obra]
                        ]);
                        if ($tarjeta) {
                            $tarjeta = \Illuminate\Support\Facades\DB::connection('cadeco')->select("SELECT top 1 id from ControlPresupuesto.tarjeta where id_obra=" . $obra->id_obra . " and descripcion='" . $conceptoPath->tarjeta . "'");
                        }
                    }
                    \Illuminate\Support\Facades\DB::connection('cadeco')->table('ControlPresupuesto.concepto_tarjeta')->insert([
                        ['id_concepto' => $conceptoPath->id_concepto, 'id_tarjeta' => $tarjeta[0]->id, 'id_obra' => $obra->id_obra]
                    ]);
                }
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }


    }
}
