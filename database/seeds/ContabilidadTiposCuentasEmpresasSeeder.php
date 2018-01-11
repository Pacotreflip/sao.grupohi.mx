<?php

use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;

class ContabilidadTiposCuentasEmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement("
        SET IDENTITY_INSERT Contabilidad.tipos_cuentas_empresas ON;
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(1,'Cuenta de Proveedor / Acreedor',NULL,NULL,2);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(2,'Cta Proveedor USD',NULL,NULL,27);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(3,'Cta Proveedor Comp.',NULL,NULL,28);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(4,'Cta de Anticipo a Proveedores',NULL,NULL,12);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(5,'Cuenta de Subcontratista',NULL,NULL,NULL);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(6,'Cta Anticipo USD',NULL,NULL,31);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(7,'Cta Anticipo Comp.',NULL,NULL,32);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(8,'Cta de Fondo de Garantía',NULL,NULL,10);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(9,'Cuenta de Anticipo a Subcontratista',NULL,NULL,NULL);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(10,'Cta otras retenciones de subcontratos',NULL,NULL,37);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(11,'Cta Fondo Garantía USD',NULL,NULL,38);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(12,'Cta Fondo Garantía Comp',NULL,NULL,39);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(13,'Cta Otras Retenciones Subcontratos USD',NULL,NULL,40);
        insert into Contabilidad.tipos_cuentas_empresas  (id, descripcion, created_at, updated_at, id_tipo_cuenta_contable) values(14,'Cta Otras Retenciones Subcontratos Comp.',NULL,NULL,41);
        SET IDENTITY_INSERT Contabilidad.tipos_cuentas_empresas OFF;
");
    }
}
