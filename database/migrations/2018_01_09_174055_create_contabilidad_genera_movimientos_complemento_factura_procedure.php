<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosComplementoFacturaProcedure extends Migration
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
                        -- Registrados en la tabla: Complemento Facturas
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosComplementoFactura] 
                          @id_int_poliza INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                          DECLARE @id_transaccion INT,
                          @usuario_registro VARCHAR(1024),
                          @cantidad_movimientos INT,
                          @complemento_factura INT,
                          @iva_en_complemento FLOAT
                        
                          SELECT @id_transaccion = id_transaccion_sao from 
                          Contabilidad.int_polizas
                          WHERE id_int_poliza = @id_int_poliza
                        
                          SELECT @usuario_registro = comentario from 
                          transacciones
                          WHERE id_transaccion = @id_transaccion;
                        
                          SELECT @iva_en_complemento = ISNULL(iva,0) from 
                          Finanzas.complemento_factura complemento_factura
                          WHERE id_transaccion = @id_transaccion;
                        
                          select @complemento_factura = count(*)
                          from  Finanzas.complemento_factura complemento_factura
                          WHERE complemento_factura.id_transaccion = @id_transaccion;
                        
                          IF @complemento_factura >0  BEGIN
                          
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
                               select * from(
                            SELECT 
                          @id_int_poliza AS tipo_transaccion,
                               23 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 23) AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               \'*IVA*\' AS descripcion,
                               complemento_factura.iva * transacciones.tipo_cambio AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro as usuario_registro,
                            transacciones.referencia
                          FROM Finanzas.complemento_factura complemento_factura
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (complemento_factura.id_transaccion =
                                         transacciones.id_transaccion)
                         WHERE complemento_factura.id_transaccion = @id_transaccion
                        UNION
                        SELECT @id_int_poliza AS tipo_transaccion,
                               25 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 25) AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               \'*OTROS IMPUESTOS*\' AS descripcion,
                                 (complemento_factura.ieps + complemento_factura.imp_hosp)
                               * transacciones.tipo_cambio
                                  AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro,
                            transacciones.referencia
                          FROM Finanzas.complemento_factura complemento_factura
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (complemento_factura.id_transaccion =
                                         transacciones.id_transaccion)
                         WHERE complemento_factura.id_transaccion = @id_transaccion
                        UNION
                        SELECT @id_int_poliza AS tipo_transaccion,
                               8 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 8) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                               \'*RETENCIÓN IVA 4%*\' AS descripcion,
                               complemento_factura.ret_iva_4 * transacciones.tipo_cambio AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro,
                            transacciones.referencia
                          FROM Finanzas.complemento_factura complemento_factura
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (complemento_factura.id_transaccion =
                                         transacciones.id_transaccion)
                         WHERE complemento_factura.id_transaccion = @id_transaccion
                        UNION
                        SELECT @id_int_poliza AS tipo_transaccion,
                               7 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 7) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                               \'*RETENCIÓN IVA 10%*\' AS descripcion,
                               complemento_factura.ret_iva_10 * transacciones.tipo_cambio AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro,
                            transacciones.referencia
                          FROM Finanzas.complemento_factura complemento_factura
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (complemento_factura.id_transaccion =
                                         transacciones.id_transaccion)
                         WHERE complemento_factura.id_transaccion = @id_transaccion
                        UNION
                        SELECT @id_int_poliza AS tipo_transaccion,
                               6 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 6) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                               \'*RETENCIÓN ISR*\' AS descripcion,
                               complemento_factura.ret_isr_10 * transacciones.tipo_cambio AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro,
                            transacciones.referencia
                          FROM Finanzas.complemento_factura complemento_factura
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (complemento_factura.id_transaccion =
                                         transacciones.id_transaccion)
                         WHERE complemento_factura.id_transaccion = @id_transaccion
                         ) as tabla
                         WHERE tabla.importe>0;
                          SELECT @cantidad_movimientos = @@ROWCOUNT;
                          PRINT \'Movimientos Complemento Facturas Registrados: \' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                         END
                        IF NOT(@iva_en_complemento>0) OR NOT(@complemento_factura >0 )
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
                          SELECT @id_int_poliza AS tipo_transaccion,
                               23 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral](transacciones.id_obra, 23) AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               \'*IVA*\' AS descripcion,
                               transacciones.impuesto AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at
                              , @usuario_registro,
                            transacciones.referencia
                          FROM 
                               dbo.transacciones transacciones
                                 
                         WHERE transacciones.id_transaccion = @id_transaccion AND transacciones.impuesto>0;
                          SELECT @cantidad_movimientos = @@ROWCOUNT;
                          PRINT \'Movimiento a IVA registrado:\' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                         END
                         
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosComplementoFactura]');
    }
}
