<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Finanzas\TipoRubro;

class TiposRubrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = ['Pasivos', 'Pagos Anticipados', 'Fondos Fijos'];

        foreach ($tipos as $t)
            TipoRubro::firstOrCreate([
                'descripcion' => $t,
            ]);
    }
}
