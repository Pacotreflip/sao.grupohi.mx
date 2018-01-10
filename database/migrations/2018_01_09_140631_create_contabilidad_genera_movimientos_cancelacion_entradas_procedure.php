<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosCancelacionEntradasProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('-- =============================================
                        -- Author:    Elizabeth Martinez Solano
                        -- Create date: 10/07/2017
                        -- Description: Procedimiento para realizar el registro de movimientos 
                        -- de cancelación de entradas realizadas previamente a la revisión de 
                        -- facturas
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosCancelacionEntradas]
                          @id_int_poliza INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                          DECLARE @id_transaccion INT,
                          @usuario_registro VARCHAR(1024),
                          @cantidad_movimientos INT
                        
                          SELECT @id_transaccion = id_transaccion_sao from 
                          Contabilidad.int_polizas
                          WHERE id_int_poliza = @id_int_poliza
                        
                          SELECT @usuario_registro = comentario from 
                          transacciones
                          WHERE id_transaccion = @id_transaccion
                        
                        
                          INSERT INTO [Contabilidad].[int_polizas_movimientos]
                                ([id_int_poliza]
                                   ,[id_tipo_cuenta_contable]
                                   ,[cuenta_contable]
                                   ,[importe]
                                   ,[id_tipo_movimiento_poliza]
                                   ,[referencia]
                                   ,[concepto]
                                   ,[id_empresa_cadeco]
                                   ,[razon_social]
                                   ,[rfc]
                                   ,[timestamp]
                               ,[created_at]
                               , id_transaccion_sao
                               , id_item_sao
                               ,usuario_registro
                            )
                        
                          SELECT 
                          @id_int_poliza,
                          29 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               sum (monto_total) * -1 AS importe,
                               1 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN ALM.* \' + almacenes.[descripcion]+\' (Cancelación de remisión)\', 100) AS concepto,
                               NULL AS id_empresa_cadeco,
                               NULL AS razon_social,
                               NULL AS rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM (((((dbo.items items_1
                                    INNER JOIN
                                    dbo.inventarios inventarios
                                       ON (items_1.id_item = inventarios.id_item))
                                   INNER JOIN dbo.items items
                                      ON (items.item_antecedente = items_1.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                                LEFT OUTER JOIN
                                (SELECT cuentas_almacenes.id,
                                        cuentas_almacenes.id_almacen,
                                        cuentas_almacenes.cuenta
                                   FROM Contabilidad.cuentas_almacenes cuentas_almacenes
                                  WHERE (cuentas_almacenes.estatus = 1)) Subquery
                                   ON (inventarios.id_almacen = Subquery.id_almacen))
                               INNER JOIN dbo.almacenes almacenes
                                  ON (almacenes.id_almacen = inventarios.id_almacen)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 Subquery.cuenta,
                                 almacenes.descripcion
                          /*cancelación de Items de costo*/
                          UNION 
                          SELECT 
                          @id_int_poliza,
                          1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               sum (monto_total) * -1 AS importe,
                               1 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN CONCEPTO.* \'
                             + conceptos_1.descripcion
                                + \'->\'
                                + conceptos.descripcion
                              +\' (Cancelación de remisión)\', 100) AS concepto,
                               NULL AS id_empresa_cadeco,
                               NULL AS razon_social,
                               NULL AS rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM (((((dbo.movimientos movimientos
                                    INNER JOIN dbo.conceptos conceptos
                                       ON (movimientos.id_concepto = conceptos.id_concepto))
                                   INNER JOIN dbo.items items_1
                                      ON (items_1.id_item = movimientos.id_item))
                                  INNER JOIN dbo.items items
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones_1
                                   ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                               LEFT OUTER JOIN
                               (SELECT cuentas_conceptos.id,
                                       cuentas_conceptos.id_concepto,
                                       cuentas_conceptos.cuenta
                                  FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                                 WHERE (cuentas_conceptos.estatus = 1) AND (cuentas_conceptos.deleted_at IS NULL) ) Subquery
                                  ON (Subquery.id_concepto = conceptos.id_concepto)
                              INNER JOIN dbo.conceptos conceptos_1
                                  ON     (substring (conceptos.nivel, 1, len (conceptos.nivel) - 4) =
                                             conceptos_1.nivel)
                                     AND (conceptos.id_obra = conceptos_1.id_obra)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 Subquery.cuenta,
                                 conceptos.descripcion,
                              conceptos_1.descripcion
                          /*cancelación de Items de IVA*/
                          UNION
                          SELECT 
                          @id_int_poliza,
                          23 AS id_tipo_cuenta_contable,
                               Subquery_1.cuenta_contable,
                               sum (monto_total * 0.16) * -1 AS importe,
                               1 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN IVA* \'+\' -Cancelación de remisión-\', 100) AS concepto,
                               NULL AS id_empresa_cadeco,
                               NULL AS razon_social,
                               NULL AS rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM ((((dbo.items items
                                   INNER JOIN dbo.items items_1
                                      ON (items.item_antecedente = items_1.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 LEFT OUTER JOIN
                                 (SELECT int_cuentas_contables.id_obra,
                                         int_cuentas_contables.id_int_tipo_cuenta_contable,
                                         int_cuentas_contables.cuenta_contable,
                                         int_cuentas_contables.deleted_at
                                    FROM Contabilidad.int_cuentas_contables int_cuentas_contables
                                   WHERE (int_cuentas_contables.deleted_at IS NULL) and int_cuentas_contables.estatus = 1) Subquery_1
                                    ON     (23 = Subquery_1.id_int_tipo_cuenta_contable)
                                       AND (transacciones.id_obra = Subquery_1.id_obra))
                                INNER JOIN
                                dbo.transacciones transacciones_1
                                   ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                               INNER JOIN
                               (SELECT inventarios.id_item, inventarios.monto_total
                                  FROM dbo.inventarios inventarios
                                UNION
                                SELECT movimientos.id_item, movimientos.monto_total
                                  FROM dbo.movimientos movimientos)
                               Subquery
                                  ON (items_1.id_item = Subquery.id_item)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 Subquery_1.cuenta_contable
                        
                          /*cancelación de Items de Proveedor pesos*/
                          UNION
                          SELECT 
                          @id_int_poliza,
                          2 AS id_tipo_cuenta_contable,
                               Subquery_1.cuenta,
                               sum (items_1.importe * 1.16) * -1 AS importe,
                               2 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN PROV. PESOS* \' + empresas.razon_social+\' -Cancelación de remisión-\', 100) AS concepto,
                               empresas.id_empresa AS id_empresa_cadeco,
                               empresas.razon_social,
                               empresas.rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM (((((dbo.items items_1
                                    INNER JOIN
                                    (SELECT inventarios.id_item, inventarios.monto_total
                                       FROM dbo.inventarios inventarios
                                     UNION
                                     SELECT movimientos.id_item, movimientos.monto_total
                                       FROM dbo.movimientos movimientos)
                                    Subquery
                                       ON (items_1.id_item = Subquery.id_item))
                                   INNER JOIN dbo.items items
                                      ON (items.item_antecedente = items_1.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 LEFT OUTER JOIN
                                 (SELECT cuentas_empresas.id_obra,
                                         cuentas_empresas.id_empresa,
                                         cuentas_empresas.estatus,
                                         cuentas_empresas.cuenta,
                                         cuentas_empresas.id_tipo_cuenta_empresa
                                    FROM Contabilidad.cuentas_empresas cuentas_empresas
                                   WHERE     (cuentas_empresas.estatus = 1)
                                         AND (cuentas_empresas.id_tipo_cuenta_empresa = 1))
                                 Subquery_1
                                    ON     (transacciones.id_obra = Subquery_1.id_obra)
                                       AND (transacciones.id_empresa = Subquery_1.id_empresa))
                                INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa))
                               INNER JOIN
                               dbo.transacciones transacciones_1
                                  ON (transacciones_1.id_transaccion = items_1.id_transaccion)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                               AND (transacciones_1.id_moneda = 1)--Sólo entradas en dólares
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 transacciones_1.id_moneda,
                                 Subquery_1.cuenta,
                             empresas.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc
                          /*cancelación de Items de Proveedor USD*/
                          UNION
                          SELECT 
                          @id_int_poliza,
                          27 AS id_tipo_cuenta_contable,
                               Subquery_1.cuenta,
                               sum (items_1.importe * 1.16) * -1 AS importe,
                               2 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN PROV. USD* \' + empresas.razon_social+\' Cancelación de remisión\', 100) AS concepto,
                               empresas.id_empresa AS id_empresa_cadeco,
                               empresas.razon_social,
                               empresas.rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM (((((dbo.items items_1
                                    INNER JOIN
                                    (SELECT inventarios.id_item, inventarios.monto_total
                                       FROM dbo.inventarios inventarios
                                     UNION
                                     SELECT movimientos.id_item, movimientos.monto_total
                                       FROM dbo.movimientos movimientos)
                                    Subquery
                                       ON (items_1.id_item = Subquery.id_item))
                                   INNER JOIN dbo.items items
                                      ON (items.item_antecedente = items_1.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 LEFT OUTER JOIN
                                 (SELECT cuentas_empresas.id_obra,
                                         cuentas_empresas.id_empresa,
                                         cuentas_empresas.estatus,
                                         cuentas_empresas.cuenta,
                                         cuentas_empresas.id_tipo_cuenta_empresa
                                    FROM Contabilidad.cuentas_empresas cuentas_empresas
                                   WHERE     (cuentas_empresas.estatus = 1)
                                         AND (cuentas_empresas.id_tipo_cuenta_empresa = 2))
                                 Subquery_1
                                    ON     (transacciones.id_obra = Subquery_1.id_obra)
                                       AND (transacciones.id_empresa = Subquery_1.id_empresa))
                                INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa))
                               INNER JOIN
                               dbo.transacciones transacciones_1
                                  ON (transacciones_1.id_transaccion = items_1.id_transaccion)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                               AND (transacciones_1.id_moneda = 2)--Sólo entradas en dólares
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 transacciones_1.id_moneda,
                                 Subquery_1.cuenta,
                             empresas.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc
                        
                          /*cancelación de Items de Proveedor Complementaria*/
                          UNION
                          SELECT @id_int_poliza,
                          28 AS id_tipo_cuenta_contable,
                               Subquery_1.cuenta,
                               (sum (monto_total) * 1.16 - sum (items_1.importe * 1.16)) * -1
                                  AS importe,
                               2 AS tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CANCELACIÓN PROV. COMP.* \' + empresas.razon_social+\' Cancelación de remisión\', 100) AS concepto,
                               empresas.id_empresa AS id_empresa_cadeco,
                               empresas.razon_social,
                               empresas.rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                          FROM (((((dbo.items items_1
                                    INNER JOIN
                                    (SELECT inventarios.id_item, inventarios.monto_total
                                       FROM dbo.inventarios inventarios
                                     UNION
                                     SELECT movimientos.id_item, movimientos.monto_total
                                       FROM dbo.movimientos movimientos)
                                    Subquery
                                       ON (items_1.id_item = Subquery.id_item))
                                   INNER JOIN dbo.items items
                                      ON (items.item_antecedente = items_1.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 LEFT OUTER JOIN
                                 (SELECT cuentas_empresas.id_obra,
                                         cuentas_empresas.id_empresa,
                                         cuentas_empresas.estatus,
                                         cuentas_empresas.cuenta,
                                         cuentas_empresas.id_tipo_cuenta_empresa
                                    FROM Contabilidad.cuentas_empresas cuentas_empresas
                                   WHERE     (cuentas_empresas.estatus = 1)
                                         AND (cuentas_empresas.id_tipo_cuenta_empresa = 3))
                                 Subquery_1
                                    ON     (transacciones.id_obra = Subquery_1.id_obra)
                                       AND (transacciones.id_empresa = Subquery_1.id_empresa))
                                INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa))
                               INNER JOIN
                               dbo.transacciones transacciones_1
                                  ON (transacciones_1.id_transaccion = items_1.id_transaccion)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones_1.tipo_transaccion = 33 and transacciones_1.opciones !=8)
                               AND (transacciones_1.id_moneda = 2)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones_1.tipo_transaccion,
                                 transacciones.comentario,
                                 transacciones.referencia,
                                 transacciones_1.id_moneda,
                                 Subquery_1.cuenta,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 empresas.id_empresa;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos de cancelación registrados:\' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosCancelacionEntradas]');
    }
}
