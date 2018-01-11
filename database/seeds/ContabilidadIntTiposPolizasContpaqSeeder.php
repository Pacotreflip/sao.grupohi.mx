<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoPolizaContpaq;

class ContabilidadIntTiposPolizasContpaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement("
        SET IDENTITY_INSERT Contabilidad.int_tipos_polizas_contpaq ON;
            insert into Contabilidad.int_tipos_polizas_contpaq(id_int_tipo_poliza_contpaq, descripcion, created_at) values(1,'Póliza de Ingresos',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108));
            insert into Contabilidad.int_tipos_polizas_contpaq(id_int_tipo_poliza_contpaq, descripcion, created_at) values(2,'Póliza de Egresos', CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108));
            insert into Contabilidad.int_tipos_polizas_contpaq(id_int_tipo_poliza_contpaq, descripcion, created_at) values(3,'Póliza de Diario',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108));
        SET IDENTITY_INSERT Contabilidad.int_tipos_polizas_contpaq OFF;
        ");
    }
}
