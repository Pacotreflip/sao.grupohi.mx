<?php

use Illuminate\Database\Seeder;

class EstatusPrepolizaLabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','No Lanzada')->update(['label'=>'#dd4b39']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Con Errores')->update(['label'=>'#dd4b39']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Por Validar')->update(['label'=>'#f39c12']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Validada')->update(['label'=>'#0073b7']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Lanzada')->update(['label'=>'#00a65a']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Omitida')->update(['label'=>'#d2d6de']);
        \Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza::where('descripcion' ,'=','Registro Manual')->update(['label'=>'#00a65a']);
    }
}
