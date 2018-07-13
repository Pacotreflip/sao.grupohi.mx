<?php


use Ghi\Domain\Core\Models\ControlPresupuesto\TipoExtraordinario;
use Illuminate\Database\Seeder;

class ControlPresupuestoTiposExtraordinariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoExtraordinario::firstOrCreate([
            'id' => '1',
            'descripcion' => 'Tarjeta'
        ]);
        TipoExtraordinario::firstOrCreate([
        'id' => '2',
        'descripcion' => 'Catálogo'
        ]);
        TipoExtraordinario::firstOrCreate([
        'id' => '3',
        'descripcion' => 'Nuevo'
        ]);
    }
}
