<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Finanzas\Rubro;

class RubrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "START RubroSeeder";
        $rubros = [
            'SUELDOS Y SALARIOS' => 1,
            'SUBCONTRATOS, ACARREOS Y DESTAJOS'=> 1,
            'MATERIALES'=> 1,
            'MAQUINARIA'=> 1,
            'ADQUISICIÓN DE ACTIVO'=> 1,
            'FINANCIEROS'=> 1,
            'HONORARIOS Y ASESORIAS'=> 1,
            'IMPUESTOS'=> 1,
            'GASTOS GENERALES'=> 1,
            'ANTICIPOS'=> 1,
            'FINIQUITOS'=> 1,
            'PAGO ANTICIPADO'=> 2,
            'GASTO POR COMPROBAR'=> 3,
            'REEMBOLSO'=> 3,
            'REPOSICIÓN FONDO FIJO'=> 3,
        ];

        $string = '';
        $id = 0;
        $len = count($rubros);
        foreach ($rubros as $descripcion => $tipo)
            $string .= "('". ++$id ."', '". $tipo ."', '". $descripcion ."', '". Carbon::now() ."', null, null)". ($id == $len  ? '': ', ');

        DB::connection("cadeco")->statement('
SET IDENTITY_INSERT Finanzas.rubros ON;
INSERT INTO Finanzas.rubros(id, id_tipo, descripcion, created_at, updated_at, deleted_at)
VALUES '. $string .';
SET IDENTITY_INSERT Finanzas.rubros OFF;');

        echo "/n  END RubrosSeeder";
    }
}
