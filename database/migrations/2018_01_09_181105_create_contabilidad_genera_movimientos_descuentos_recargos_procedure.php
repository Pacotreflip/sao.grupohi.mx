<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosDescuentosRecargosProcedure extends Migration
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
                          CREATE PROCEDURE [Contabilidad].[generaMovimientosDescuentosRecargos] 
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
                            ,referencia
                            )
                        
                          SELECT
                          @id_int_poliza,
                           NULL AS id_tipo_cuenta_contable,
                               NULL AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               varios.descripcion AS concepto,
                               CASE
                                  WHEN items.numero = 6 THEN sum (items.importe) * -1
                                  WHEN items.numero = 5 THEN sum (items.importe)
                               END
                                  AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro,
                            transacciones.referencia
                          FROM (((dbo.transacciones transacciones
                                  INNER JOIN dbo.items items
                                     ON (transacciones.id_transaccion = items.id_transaccion))
                                 INNER JOIN dbo.monedas monedas
                                    ON (transacciones.id_moneda = monedas.id_moneda))
                                INNER JOIN dbo.monedas monedas_1
                                   ON (monedas_1.id_moneda = transacciones.id_moneda))
                               INNER JOIN dbo.varios varios
                                  ON (varios.id_vario = items.item_antecedente)
                         WHERE     (items.numero IN (5, 6))
                               AND (transacciones.id_transaccion = @id_transaccion AND items.numero IN (5, 6))
                        GROUP BY varios.descripcion,
                                 items.numero,
                                 monedas.nombre,
                                 monedas_1.nombre,
                             transacciones.referencia;
                        
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos descuentos y recargos registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosDescuentosRecargos]');
    }
}
