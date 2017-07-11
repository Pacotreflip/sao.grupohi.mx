<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatosContablesObraSeeder::class);
        $this->call(TiposCuentasGeneralesObraSeeder::class);
        $this->call(TiposCuentasSeeder::class);
        $this->call(TiposPolizasContpaqSeeder::class);
        $this->call(TiposMovimientosSeeder::class);
    }
}
