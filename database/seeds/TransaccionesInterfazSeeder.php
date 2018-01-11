<?php

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TransaccionesInterfazSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("cadeco")->statement("SET IDENTITY_INSERT Contabilidad.int_transacciones_interfaz ON;
            SET IDENTITY_INSERT Contabilidad.int_transacciones_interfaz ON;
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	1	,'Póliza de Factura de Prestaciones');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	2	,'Póliza de Provisión de Pasivo de Insumos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	3	,'Póliza de Factura Solo Materiales');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	4	,'Póliza de Factura Solo de Servicios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	5	,'Póliza de Factura Solo de Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	6	,'Póliza de Factura de Materiales y Servicios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	7	,'Póliza de Factura de Materiales y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	8	,'Póliza de Factura de Servicios y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	9	,'Póliza de Factura de Materiales, Servicios y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	10	,'Póliza de Factura de Anticipo Solo Materiales');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	11	,'Póliza de Factura de Anticipo Solo de Servicios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	12	,'Póliza de Factura de Anticipo Solo de Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	13	,'Póliza de Factura de Anticipo de Materiales y Servicios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	14	,'Póliza de Factura de Anticipo de Materiales y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	15	,'Póliza de Factura de Anticipo de Servicios y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	16	,'Póliza de Factura de Anticipo de Materiales, Servicios y Herramienta y Equipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	17	,'Póliza de Pago de Factura de Anticipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	18	,'Póliza de Pago de Factura');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	19	,'Póliza de Provisión de Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	20	,'Póliza de Factura de Estimación');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	21	,'Póliza de Factura de Anticipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	22	,'Poliza de Factura de Anticipo y Estimación');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	23	,'Póliza de Pago de Anticipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	24	,'Póliza de Pago de Factura de Estimación');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	25	,'Póliza de Pago de Anticipo y Factura de Estimación');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	26	,'Póliza de Factura de Varios (Gastos Varios)');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	27	,'Póliza de Factura de Varios (Materiales/Servicios)');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	28	,'Póliza de Factura de Varios (Gastos Varios y Materiales/Servicios)');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	29	,'Póliza de Pago de Factura de Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	30	,'Póliza de Provisión de Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	31	,'Póliza de Factura de Lista de Raya');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	32	,'Póliza de Factura de Prestaciones y Lista de Raya');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	33	,'Póliza de Pago de Lista de Raya/Prestación');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	34	,'Póliza de Provisión de Rentas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	35	,'Póliza de Factura de Anticipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	36	,'Póliza de Factura de Partes de Uso');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	37	,'Póliza de Factura de Anticipo y Partes de Uso');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	38	,'Póliza de Pago de Anticipo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	39	,'Póliza de Pago de Partes de Uso');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	40	,'Póliza de Pago de Anticipo y Partes de Uso ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	41	,'Póliza de Pago a Cuenta No Aplicado');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	42	,'Póliza de Pago a Cuenta Aplicado');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	43	,'Póliza de Facturas de Insumos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	44	,'Póliza de Facturas de Rentas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	45	,'Póliza de Facturas de Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	46	,'Póliza de Facturas de Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	47	,'Póliza de Facturas de Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	48	,'Póliza de Facturas de Insumos y Rentas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	49	,'Póliza de Facturas de Insumos y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	50	,'Póliza de Facturas de Insumos y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	51	,'Póliza de Facturas de Insumos Y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	52	,'Póliza de Facturas de Rentas y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	53	,'Póliza de Facturas de Rentas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	54	,'Póliza de Facturas de Rentas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	55	,'Póliza de Facturas de Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	56	,'Póliza de Facturas de Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	57	,'Póliza de Facturas de Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	58	,'Póliza de Facturas de Insumos, Rentas y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	59	,'Póliza de Facturas de Insumos, Rentas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	60	,'Póliza de Facturas de Insumos, Rentas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	61	,'Póliza de Facturas de Insumos, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	62	,'Póliza de Facturas de Insumos, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	63	,'Póliza de Facturas de Insumos, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	64	,'Póliza de Facturas de Rentas, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	65	,'Póliza de Facturas de Rentas, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	66	,'Póliza de Facturas de Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	67	,'Póliza de Facturas de Rentas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	68	,'Póliza de Facturas de Insumos, Rentas, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	69	,'Póliza de Facturas de Insumos, Rentas, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	70	,'Póliza de Facturas de Insumos, Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	71	,'Póliza de Facturas de Insumos, Rentas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	72	,'Póliza de Facturas de Rentas, Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	73	,'Póliza de Insumos, Rentas, Rayas, Fac. de Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	74	,'Póliza de Pago de Facturas de Insumos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	75	,'Póliza de Pago de Facturas de Rentas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	76	,'Póliza de Pago de Facturas de Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	77	,'Póliza de Pago de Facturas de Insumos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	78	,'Póliza de Pago de Facturas de Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	79	,'Póliza de Pago de Facturas de Insumos y Rentas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	80	,'Póliza de Pago de Facturas de Insumos y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	81	,'Póliza de Pago de Facturas de Insumos y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	82	,'Póliza de Pago de Facturas de Insumos Y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	83	,'Póliza de Pago de Facturas de Rentas y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	84	,'Póliza de Pago de Facturas de Rentas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	85	,'Póliza de Pago de Facturas de Rentas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	86	,'Póliza de Pago de Facturas de Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	87	,'Póliza de Pago de Facturas de Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	88	,'Póliza de Pago de Facturas de Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	89	,'Póliza de Pago de Facturas de Insumos, Rentas y Rayas');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	90	,'Póliza de Pago de Facturas de Insumos, Rentas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	91	,'Póliza de Pago de Facturas de Insumos, Rentas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	92	,'Póliza de Pago de Facturas de Insumos, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	93	,'Póliza de Pago de Facturas de Insumos, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	94	,'Póliza de Pago de Facturas de Insumos, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	95	,'Póliza de Pago de Facturas de Rentas, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	96	,'Póliza de Pago de Facturas de Rentas, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	97	,'Póliza de Pago de Facturas de Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	98	,'Póliza de Pago de Facturas de Rentas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	99	,'Póliza de Pago de Facturas de Insumos, Rentas, Rayas y Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	100	,'Póliza de Pago de Facturas de Insumos, Rentas, Rayas y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	101	,'Póliza de Pago de Facturas de Insumos, Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	102	,'Póliza de Pago de Facturas de Insumos, Rentas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	103	,'Póliza de Pago de Facturas de Rentas, Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	104	,'Póliza de Pago de Facturas de Insumos, Rentas, Rayas, Varios y Subcontratos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	105	,'Póliza de Pago de Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	106	,'Póliza de Pago de Pago Varios por Pago de Lista de Raya');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	107	,'Póliza de Pago de Pago Varios por Anticipos y Destajos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	108	,'Póliza de Pago de Pago Varios por Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	109	,'Póliza de Pago de Pago Varios por Remplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	110	,'Póliza de Pago de Pago Varios por Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	111	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	112	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos, Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	113	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos, Reemplazo de Cheque y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	114	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	115	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Anticipos y Destajos, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	116	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	117	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos y Gastos Varios,');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	118	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos y Reemplazo de Cheque,');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	119	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Anticipos y Destajos y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	120	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	121	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	122	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	123	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos, Gastos Varios y Reemplazo de Cheque ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	124	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos, Gastos Varios y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	125	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	126	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	127	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos, Gastos Varios, Reemplazo de Cheque y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	128	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya y Anticipos y Destajos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	129	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	130	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	131	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Pago de Lista de Raya y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	132	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Anticipos y Destajos, y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	133	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Anticipos y Destajos y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	134	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Anticipos y Destajos y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	135	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	136	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	137	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	138	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	139	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	140	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Anticipos y Destajos y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	141	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	142	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	143	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya, Reemplazo de Cheque y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	144	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos, Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	145	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos, Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	146	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos, Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	147	,'Póliza de Pago de Pago Varios Por Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	148	,'Póliza de Pago de Pago Varios Por Gastos Varios y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	149	,'Póliza de Pago de Pago Varios Por Reemplazo de Cheque y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	150	,'Póliza de Pago de Pago Varios Por Gastos Varios y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	151	,'Póliza de Pago de Pago Varios Por Gastos Varios y Pago a Cuenta');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	152	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	153	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	154	,'Póliza de Pago de Pago Varios Por Anticipos y Destajos y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	155	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya y Anticipos y Destajos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	156	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	157	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	158	,'Póliza de Pago de Pago Varios Por Pago de Lista de Raya y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	159	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo y Pago a Cuenta ');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	160	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo y Reemplazo de Cheque');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	161	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo y Gastos Varios');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	162	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo y  Anticipos y Destajos');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	163	,'Póliza de Pago de Pago Varios Por Reposición de Fondo Fijo y Pago de Lista de Raya');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	164	,'Póliza de Pago de Insumos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	165	,'Póliza de Pago de Rentas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	166	,'Póliza de Pago de Rayas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	167	,'Póliza de Pago de Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	168	,'Póliza de Pago de Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	169	,'Póliza de Pago de Insumos, Rentas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	170	,'Póliza de Pago de Insumos, Rayas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	171	,'Póliza de Pago de Insumos, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	172	,'Póliza de Pago de Insumos, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	173	,'Póliza de Pago de Rentas, Rayas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	174	,'Póliza de Pago de Rentas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	175	,'Póliza de Pago de Rentas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	176	,'Póliza de Pago de Rayas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	177	,'Póliza de Pago de Rayas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	178	,'Póliza de Pago de Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	179	,'Póliza de Pago de Insumos, Rentas, Rayas y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	180	,'Póliza de Pago de Insumos, Rentas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	181	,'Póliza de Pago de Insumos, Rentas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	182	,'Póliza de Pago de Insumos, Rayas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	183	,'Póliza de Pago de Insumos, Rayas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	184	,'Póliza de Pago de Insumos, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	185	,'Póliza de Pago de Rentas, Rayas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	186	,'Póliza de Pago de Rentas, Rayas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	187	,'Póliza de Pago de Rentas, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	188	,'Póliza de Pago de Rayas, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	189	,'Póliza de Pago de Insumos, Rentas, Rayas, Varios y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	190	,'Póliza de Pago de Insumos, Rentas, Rayas, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	191	,'Póliza de Pago de Insumos, Rentas, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	192	,'Póliza de Pago de Insumos, Rayas, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	193	,'Póliza de Pago de Rentas, Rayas, Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	194	,'Póliza de Pago de Insumos, Rentas, Rayas,Varios, Subcontratos y Pago Varios por Reposición de Fondo Fijo');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	389	,'Póliza de Entrada de Almacén');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	390	,'Póliza de Salida de Almacén');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	391	,'Póliza de Transferencia de Almacén');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	392	,'Póliza de Cancelación de Registro de Remisión');	
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	393	,'Póliza de Factura');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	394	,'Póliza de Pago');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	395	,'Póliza de Cancelación de Entrada de Almacén');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	396	,'Póliza de Cancelación de Salida de Almacén');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	397	,'Póliza de Cancelación de Transferencia de Almacén');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	398	,'Póliza de Cancelación de Factura');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	399	,'Póliza de Cancelación de Pago');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	400	,'Póliza de Reembolso');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	401	,'Póliza Transferencia Entre Cuentas Bancarias');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	402	,'Póliza de Movimientos Bancarios');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	403	,'Póliza de Pago de ISR');
insert into Contabilidad.int_transacciones_interfaz(id_transaccion_interfaz, descripcion) values(	404	,'Póliza de Reclasificación');	

            ");
    }
}
