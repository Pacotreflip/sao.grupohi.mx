<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContabilidadPolizaTipoSAOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("cadeco")->statement("SET IDENTITY_INSERT Contabilidad.poliza_tipo_sao ON;          
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(2,'Compra Simple Activo Fijo M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(4,'Compra Simple Materiales M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(6,'Compra Simple a Costo M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(7,'Anticipo a Proveedores M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(8,'Compra Con Amortización De Anticipo M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(10,'Compra Con Retención M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(11,'Compra Con Amortización y Retención de Anticipo M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(12,'Compra Simple Activo Fijo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(14,'Compra Simple Materiales USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(16,'Compra Simple a Costo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(17,'Anticipo a Proveedores USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(18,'Compra con Amortización de Anticipo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(19,'Compra Con Retención USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(21,'Compra Con Amortización y Retención de Anticipo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(22,'Subcontratos Simples M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(23,'Subcontrato con Amortización de Anticipo M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(25,'Subcontrato con Retención Fondo Garantía M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(27,'Subcontrato con Retención de Fondo de Garantía y Retención de Atraso de Obra M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(29,'Subcontrato con Amortización de Anticipo y Retenciones M.N.',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(31,'Subcontratos Simples USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(33,'Subcontrato con Amortización de Anticipo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(34,'Subcontrato con Retención Fondo Garantía USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(35,'Subcontrato con Retención de Fondo de Garantía y Retención de Atraso de Obra USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(37,'Subcontrato con Amortización de Anticipo y Retenciones USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(39,'Renta de Maquinaria Simple MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(42,'Renta de Maquinaria con Amortización de Anticipo MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(43,'Renta de Maquinaria con retenciones de flete MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(44,'Renta de Maquinaria con amortización de anticipo y renteciones MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(46,'Rentas de Maquinaria simple USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(47,'Renta maquinaria con amortización de anticipo USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(49,'Renta de maquinaria con retenciones de USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(51,'Renta de maquinaria con amortización de anticipo y retenciones de USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(52,'Factura de varios simples',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(53,'Facturas para reembolsos de gastos',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(54,'Arrendamiento PF a PM uso comercial',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(55,'Arrendamiento PF a PM casa habitación',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(56,'Honorarios de PF a PM',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(57,'Factura de Varios Simples USD',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(58,'Servicios de personal y suplidos (listas de raya) MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(59,'Anticipo a proveedores MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(60,'Servicio de personal y suplidos (LR) con amortización de anticipo MN',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(62,'Comisión Bancaria',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(63,'Intereses Bancarios',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(64,'Pagos de Cuentas por Pagar',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(65,'Retenciones ISR bancario',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(66,'Factura de Ingresos',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
                        insert into Contabilidad.poliza_tipo_sao(id,descripcion,estatus,id_obra,created_at) values(67,'Cobranza Factura de Ingresos',1,1,CONVERT(VARCHAR(10), GETDATE(), 121) +' '+ CONVERT(VARCHAR(8), GETDATE(), 108) );
               SET IDENTITY_INSERT Contabilidad.poliza_tipo_sao OFF;
            ");
    }
}
