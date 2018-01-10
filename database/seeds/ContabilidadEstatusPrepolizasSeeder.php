<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza;

class ContabilidadEstatusPrepolizasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstatusPrePoliza::create(['estatus' => -2, 'descripcion' => 'No Lanzada',      'label'=>'#dd4b39']);
        EstatusPrePoliza::create(['estatus' => -1, 'descripcion' => 'Con Errores',     'label'=>'#dd4b39']);
        EstatusPrePoliza::create(['estatus' => 0,  'descripcion' => 'Por Validar',     'label'=>'#f39c12']);
        EstatusPrePoliza::create(['estatus' => 1,  'descripcion' => 'Validada',        'label'=>'#0073b7']);
        EstatusPrePoliza::create(['estatus' => 2,  'descripcion' => 'Lanzada',         'label'=>'#00a65a']);
        EstatusPrePoliza::create(['estatus' => -3, 'descripcion' => 'Omitida',         'label'=>'#d2d6de']);
        EstatusPrePoliza::create(['estatus' => 3,  'descripcion' => 'Registro Manual', 'label'=>'#00a65a']);
    }
}
