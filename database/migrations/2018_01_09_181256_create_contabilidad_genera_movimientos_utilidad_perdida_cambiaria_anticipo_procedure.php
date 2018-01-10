<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosUtilidadPerdidaCambiariaAnticipoProcedure extends Migration
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
                        -- Create date: 07/07/2017
                        -- Description: Procedimiento para realizar el registro de movimientos 
                        -- relacionados anticipos de compras o subcontratos.
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosUtilidadPerdidaCambiariaAnticipo] 
                          @id_int_poliza INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                          DECLARE @id_transaccion INT,
                          @usuario_registro VARCHAR(1024),
                          @cantidad_movimientos INT,
                          @referencia NVARCHAR(100),
                          @importe_utilidad_perdida_cambiaria FLOAT,
                          @importe_tipo_cambio_amortizacion FLOAT,
                          @importe_tipo_cambio_anticipo FLOAT;
                        
                          SELECT @id_transaccion = id_transaccion_sao from 
                          Contabilidad.int_polizas
                          WHERE id_int_poliza = @id_int_poliza;
                        
                          SELECT @usuario_registro = comentario from 
                          transacciones
                          WHERE id_transaccion = @id_transaccion;
                        
                        
                          -- SELECT
                               -- @importe_tipo_cambio_amortizacion = sum(items_1.importe 
                             -- * transacciones.tipo_cambio 
                             -- * (items_1.anticipo / 100))
                                  -- ,
                        
                              -- @importe_tipo_cambio_anticipo =   sum(items_1.importe
                               -- * transacciones_1.tipo_cambio
                               -- * (items_1.anticipo / 100))
                                  
                          -- FROM ((((dbo.items items_2
                                   -- INNER JOIN dbo.items items_3
                                      -- ON (items_2.id_item = items_3.item_antecedente))
                                  -- INNER JOIN dbo.items items_1
                                     -- ON (items_1.item_antecedente = items_2.id_item))
                                 -- INNER JOIN dbo.items items
                                    -- ON (items.item_antecedente = items_1.id_item))
                                -- INNER JOIN dbo.transacciones transacciones
                                   -- ON (transacciones.id_transaccion = items.id_transaccion))
                               -- INNER JOIN
                               -- dbo.transacciones transacciones_1
                                  -- ON (items_3.id_transaccion = transacciones_1.id_transaccion)
                         -- WHERE     (transacciones.id_transaccion = @id_transaccion)
                               -- AND (transacciones_1.tipo_transaccion = 65)
                              -- group by transacciones.id_transaccion;
                            
                            
                            SELECT @importe_utilidad_perdida_cambiaria = sum (estimacion_items.importe)
                               * (subcontrato.anticipo / 100)
                               * (factura_subcontrato.tipo_cambio - factura_estimacion.tipo_cambio)
                                  
                          FROM (((((dbo.transacciones subcontrato
                                    INNER JOIN
                                    dbo.items factura_subcontrato_items
                                       ON (subcontrato.id_transaccion =
                                              factura_subcontrato_items.id_antecedente))
                                   INNER JOIN dbo.transacciones estimacion
                                      ON (estimacion.id_antecedente = subcontrato.id_transaccion))
                                  INNER JOIN
                                  dbo.items factura_estimacion_items
                                     ON (factura_estimacion_items.id_antecedente =
                                            estimacion.id_transaccion))
                                 INNER JOIN
                                 dbo.transacciones factura_estimacion
                                    ON (factura_estimacion.id_transaccion =
                                           factura_estimacion_items.id_transaccion))
                                INNER JOIN dbo.items estimacion_items
                                   ON (estimacion_items.id_transaccion = estimacion.id_transaccion))
                               INNER JOIN
                               dbo.transacciones factura_subcontrato
                                  ON (factura_subcontrato_items.id_transaccion =
                                         factura_subcontrato.id_transaccion)
                         WHERE     (factura_estimacion.id_transaccion = @id_transaccion)
                               AND (factura_subcontrato.tipo_transaccion = 65)
                        GROUP BY factura_estimacion.id_transaccion,
                                 factura_subcontrato.tipo_transaccion,
                                 factura_estimacion.tipo_cambio,
                                 factura_subcontrato.tipo_cambio,
                                 subcontrato.anticipo
                        
                        
                          IF abs(@importe_utilidad_perdida_cambiaria) > 1
                          BEGIN
                          IF @importe_utilidad_perdida_cambiaria < 0
                          BEGIN
                        
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
                              35
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 35) 
                                  AS cuenta_contable,
                              2
                                  AS id_tipo_movimiento_poliza,
                                LEFT (\'*UTILIDAD CAMBIARIA*  \' , 100) as concepto,
                               abs(@importe_utilidad_perdida_cambiaria) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro,
                              referencia
                          from transacciones where id_transaccion = @id_transaccion
                             ;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos de utilidad cambiaria por anticipo registrados:\' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                         END 
                         ELSE
                         BEGIN 
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
                              36
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 36) 
                                  AS cuenta_contable,
                              1
                                  AS id_tipo_movimiento_poliza,
                                LEFT (\'*PERDIDA CAMBIARIA*  \' , 100) as concepto,
                               abs(@importe_utilidad_perdida_cambiaria) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro,
                              referencia
                              from transacciones where id_transaccion = @id_transaccion
                          
                             ;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos de perdida cambiaria por anticipo registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                         END
                         END
                        
                        
                         /*UTILIDAD PERDIDA CAMBIARIA POR ANTICIPOS DE TRANSACCIONES TIPO 19*/
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosUtilidadPerdidaCambiariaAnticipo]');
    }
}
