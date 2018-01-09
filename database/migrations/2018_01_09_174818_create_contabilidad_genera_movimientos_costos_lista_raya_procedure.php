<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosCostosListaRayaProcedure extends Migration
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
                        -- al costo originados de las salidas de almacén involuvradas en las LR
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosCostosListasDeRaya] 
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
                            ,[id_tipo_movimiento_poliza]
                            ,[concepto]
                                ,[importe]
                                ,[timestamp]
                            ,[created_at]
                            ,[usuario_registro]
                            )
                        
                          SELECT
                          @id_int_poliza,
                           1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               1 AS id_tipo_movimiento_poliza,
                               LEFT (
                                    \'* CONC. \'
                                  + conceptos.descripcion
                                  + \'->\'
                                  + conceptos_1.descripcion
                                  + \'*\',
                                  100)
                                  AS concepto,
                               SUM (movimientos.monto_total) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro
                          FROM (((((((((dbo.movimientos movimientos
                                        INNER JOIN
                                        dbo.conceptos conceptos
                                           ON (movimientos.id_concepto = conceptos.id_concepto))
                                       INNER JOIN
                                       dbo.inventarios inventarios
                                          ON (inventarios.id_lote = movimientos.lote_antecedente))
                                      INNER JOIN dbo.items items_1
                                         ON (items_1.id_item = inventarios.id_item))
                                     INNER JOIN
                                     dbo.transacciones transacciones_1
                                        ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                                    INNER JOIN dbo.items items
                                       ON (items.id_antecedente = transacciones_1.id_transaccion))
                                   INNER JOIN
                                   dbo.transacciones transacciones
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                  INNER JOIN dbo.almacenes almacenes
                                     ON (items_1.id_almacen = almacenes.id_almacen))
                                 INNER JOIN dbo.items items_2
                                    ON (movimientos.id_item = items_2.id_item))
                                INNER JOIN dbo.conceptos conceptos_1
                                   ON     (substring (conceptos.nivel, 1, len (conceptos.nivel) - 4) =
                                              conceptos_1.nivel)
                                      AND (conceptos.id_obra = conceptos_1.id_obra))
                               LEFT OUTER JOIN
                               (SELECT cuentas_conceptos.id,
                                       cuentas_conceptos.cuenta,
                                       cuentas_conceptos.id_concepto,
                                       cuentas_conceptos.estatus
                                  FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                                 WHERE (cuentas_conceptos.deleted_at IS NULL
                              ) AND (cuentas_conceptos.estatus = 1)) Subquery
                                  ON (conceptos.id_concepto = Subquery.id_concepto)
                         WHERE     (movimientos.monto_total > 0.1)
                               AND (transacciones.id_transaccion = @id_transaccion)
                             AND transacciones.tipo_transaccion in(99,102)
                        GROUP BY conceptos.id_concepto,
                                 conceptos.descripcion,
                                 transacciones.id_transaccion,
                                 substring (conceptos.nivel, 1, len (conceptos.nivel) - 4),
                                 conceptos_1.descripcion,
                                 Subquery.cuenta;
                        
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos a costo por LR registrados:\' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosCostosListasDeRaya]');
    }
}
