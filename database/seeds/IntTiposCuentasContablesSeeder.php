<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntTiposCuentasContablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("cadeco")->statement("SET IDENTITY_INSERT Contabilidad.int_tipos_cuentas_contables ON;
            SET IDENTITY_INSERT Contabilidad.int_tipos_cuentas_contables ON;
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(1,'Cuenta de Costo',GETDATE(),1,3250,NULL,2,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(2,'Cuenta de Proveedor / Acreedor', GETDATE(),1,3250,NULL,2,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(3,'Cta de IVA Acreditable No Pagado 15%',GETDATE(),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(4,'Cta de IVA Acreditable Pagado 15%',GETDATE(),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(5,'Cta de IVA Acreditable Pagado 10%',GETDATE(),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(6,'Cta de ISR Retenido Arrendamiento',GETDATE(),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(7,'Cta de IVA Retenido Arrendamiento',GETDATE(),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(8,'Cta de IVA Retenido 4%',GETDATE(),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(9,'Cta de Impuesto Cedular',GETDATE(),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(10,'Cta de Fondo de Garantía',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(11,'Cta de Anticipo a Contratistas',GETDATE(),1,3250,'GETDATE()',2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(12,'Cta de Anticipo a Proveedores',GETDATE(),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(13,'Cta de Provisión de Pasivo de Materiales',GETDATE(),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(14,'Cta de Provisión de Costo de Materiales',GETDATE(),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(15,'Cta de Banco',GETDATE(),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(16,'Cta de Provisión de Pasivo de Subcontratos',GETDATE(),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(17,'Cta de Provisión de Pasivo de Obra',GETDATE(),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(18,'Cta de Provisión de Pasivo de Renta de Maquinaria',GETDATE(),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(19,'Cta de Provisión de Costo de Subcontratos',GETDATE(),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(20,'Cta de Provisión de Costo de Renta de Maquinaria',GETDATE(),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(21,'Cta de Provisión de Costo de Mano de Obra',GETDATE(),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(22,'Cta de Obras y Oficinas',GETDATE(),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(23,'Cta de IVA Acreditable No Pagado 16%',GETDATE(),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(24,'Cta de IVA Acreditable Pagado 16%',GETDATE(),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(25,'Cta de Otros Impuestos y Derechos',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(26,'Cta Costo Materiales',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(27,'Cta Proveedor USD',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(28,'Cta Proveedor Comp.',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(29,'Cta Almacen',GETDATE(),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(30,'Cta Contratista',GETDATE(),1,3250,'GETDATE()',2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(31,'Cta Anticipo USD',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(32,'Cta Anticipo Comp.',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(33,'Cta de Inventario Materiales',GETDATE(),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(34,'Activo Fijo',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(35,'Cta Utilidad Cambiaria',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(36,'Cta Perdida Cambiaria',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(37,'Cuenta Otras retenciones subcontratos' ,GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(38,'Cta. Fondo de Garantía  USD',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(39,'Cta. Fondo de Garantía Comp',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(40,'Cta. Otras Retenciones Subcontratos USD',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(41,'Cta. Otras Retenciones Subcontratos Comp',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(42,'Cta. de ISR Retenido Honorarios' ,GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(43,'Cta. de IVA Retenido Honorarios',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(44,'Cta. Ingresos Financieros (intereses)',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(45,'Cta. ISR Retenido Bancos',GETDATE(),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(46,'Cta. Estimaciones por Cobrar MN ',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(47,'Ingresos por Estimaciones ',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(48,'Cta. IVA Trasladado No Cobrado' ,GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(49,'Cta. IVA Trasladado  Cobrado',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(50,'Cta. Retenciones en Estimaciones por Cobrar',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(51,'Cta. Anticipo de Clientes',GETDATE(),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(52,'Cta. Costos (Otros Impuestos y Derechos)',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(53,'Gastos Amortizables',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(54,'Cta. Proveedor Global',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(55,'Cta. Fondo Fijo',GETDATE(),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(56,'Cta. Deudores',GETDATE(),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(57,'Cta. Deudores USD',GETDATE(),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(58,'Cta. Deudores Comp.',GETDATE(),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(59,'Cta. Intereses Bancarios',GETDATE(),1,3250,NULL,5,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(60,'Cta. Comisiones Bancarias',GETDATE(),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(61,'Cta. Contribuciones Federales',GETDATE(),1,3250,NULL,5,1);

        ");
    }
}
