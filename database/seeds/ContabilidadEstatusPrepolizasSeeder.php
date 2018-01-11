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
        DB::connection("cadeco")->statement('
        SET IDENTITY_INSERT Contabilidad.estatus_prepolizas ON;
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (8,\'-2\', \'No Lanzada\',\'#dd4b39\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (9,\'-1\', \'Con Errores\',\'#dd4b39\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (10,\'0\', \'Por Validar\', \'#f39c12\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (11,\'1\', \'Validada\', \'#0073b7\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (12,\'2\', \'Lanzada\', \'#00a65a\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (13,\'-3\', \'Omitida\', \'#d2d6de\');
            insert into Contabilidad.estatus_prepolizas (id, estatus, descripcion, label) values (14,\'3\', \'Registro Manual\', \'#00a65a\');
        SET IDENTITY_INSERT Contabilidad.estatus_prepolizas OFF;
        ');
    }
}
