<?php

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Seeder;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaContable;

class ContabilidadIntTiposCuentasContablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement("
        SET IDENTITY_INSERT Contabilidad.int_tipos_cuentas_contables ON;
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(1,'Cuenta de Costo',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(2,'Cuenta de Proveedor / Acreedor', CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(3,'Cta de IVA Acreditable No Pagado 15%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(4,'Cta de IVA Acreditable Pagado 15%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(5,'Cta de IVA Acreditable Pagado 10%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(6,'Cta de ISR Retenido Arrendamiento',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(7,'Cta de IVA Retenido Arrendamiento',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(8,'Cta de IVA Retenido 4%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(9,'Cta de Impuesto Cedular',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(10,'Cta de Fondo de Garantía',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(11,'Cta de Anticipo a Contratistas',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(12,'Cta de Anticipo a Proveedores',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(13,'Cta de Provisión de Pasivo de Materiales',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(14,'Cta de Provisión de Costo de Materiales',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(15,'Cta de Banco',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(16,'Cta de Provisión de Pasivo de Subcontratos',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(17,'Cta de Provisión de Pasivo de Obra',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(18,'Cta de Provisión de Pasivo de Renta de Maquinaria',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(19,'Cta de Provisión de Costo de Subcontratos',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(20,'Cta de Provisión de Costo de Renta de Maquinaria',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(21,'Cta de Provisión de Costo de Mano de Obra',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,4,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(22,'Cta de Obras y Oficinas',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,3,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(23,'Cta de IVA Acreditable No Pagado 16%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(24,'Cta de IVA Acreditable Pagado 16%',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(25,'Cta de Otros Impuestos y Derechos',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(26,'Cta Costo Materiales',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(27,'Cta Proveedor USD',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(28,'Cta Proveedor Comp.',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(29,'Cta Almacen',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(30,'Cta Contratista',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(31,'Cta Anticipo USD',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(32,'Cta Anticipo Comp.',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(33,'Cta de Inventario Materiales',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,NULL);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(34,'Activo Fijo',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(35,'Cta Utilidad Cambiaria',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(36,'Cta Perdida Cambiaria',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(37,'Cuenta Otras retenciones subcontratos' ,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(38,'Cta. Fondo de Garantía  USD',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(39,'Cta. Fondo de Garantía Comp',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(40,'Cta. Otras Retenciones Subcontratos USD',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(41,'Cta. Otras Retenciones Subcontratos Comp',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(42,'Cta. de ISR Retenido Honorarios' ,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(43,'Cta. de IVA Retenido Honorarios',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(44,'Cta. Ingresos Financieros (intereses)',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(45,'Cta. ISR Retenido Bancos',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(46,'Cta. Estimaciones por Cobrar MN ',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(47,'Ingresos por Estimaciones ',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(48,'Cta. IVA Trasladado No Cobrado' ,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(49,'Cta. IVA Trasladado  Cobrado',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(50,'Cta. Retenciones en Estimaciones por Cobrar',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(51,'Cta. Anticipo de Clientes',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(52,'Cta. Costos (Otros Impuestos y Derechos)',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(53,'Gastos Amortizables',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(54,'Cta. Proveedor Global',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(55,'Cta. Fondo Fijo',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,1,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(56,'Cta. Deudores',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(57,'Cta. Deudores USD',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(58,'Cta. Deudores Comp.',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,2,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(59,'Cta. Intereses Bancarios',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,5,2);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(60,'Cta. Comisiones Bancarias',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,5,1);
            insert into Contabilidad.int_tipos_cuentas_contables(id_tipo_cuenta_contable, descripcion, created_at, id_obra, registro,  deleted_at, tipo, id_naturaleza_poliza) values(61,'Cta. Contribuciones Federales',CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108),1,3250,NULL,5,1);
        SET IDENTITY_INSERT Contabilidad.int_tipos_cuentas_contables OFF;
        ");
    }
}