<?php

use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\Estatus;

class ControlCostosEstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement('
        SET IDENTITY_INSERT ControlCostos.estatus ON;
            insert into ControlCostos.estatus (id, estatus, descripcion, created_at) values (1,\'1\',\'Solicitada\',CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108));
            insert into ControlCostos.estatus (id, estatus, descripcion, created_at) values (2,\'2\',\'Autorizada\',CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108));
            insert into ControlCostos.estatus (id, estatus, descripcion, created_at) values (3,\'-1\',\'Rechazada\',CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108));
        SET IDENTITY_INSERT ControlCostos.estatus OFF;
        ');
    }
}
