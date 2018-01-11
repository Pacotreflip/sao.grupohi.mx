<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosAlmacenesItemsProcedure extends Migration
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
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosAlmacenesDesdeItems] 
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
                        29 as [id_tipo_cuenta_contable],
                        cuentas_almacenes.cuenta,
                        1 AS [id_tipo_movimiento_poliza],
                        \'* ALM. \' + almacenes.descripcion + TipoTran.Descripcion + \'*\'
                                  AS concepto,
                                  sum (items.cantidad * items.precio_unitario * transacciones.tipo_cambio) AS importe,
                                  CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [created_at],
                            @usuario_registro  
                               ,transacciones.referencia
                          FROM (((((((dbo.transacciones transacciones
                                      INNER JOIN dbo.empresas empresas
                                         ON (transacciones.id_empresa = empresas.id_empresa))
                                     INNER JOIN dbo.items items
                                        ON (transacciones.id_transaccion = items.id_transaccion))
                                    LEFT OUTER JOIN
                                    dbo.transacciones transacciones_3
                                       ON (items.id_antecedente = transacciones_3.id_transaccion))
                                   LEFT OUTER JOIN dbo.TipoTran TipoTran
                                      ON     (transacciones_3.tipo_transaccion =
                                                 TipoTran.Tipo_Transaccion)
                                         AND (transacciones_3.opciones = TipoTran.Opciones))
                                  LEFT OUTER JOIN dbo.items items_1
                                     ON (items.item_antecedente = items_1.id_item))
                                 LEFT OUTER JOIN
                                 Contabilidad.cuentas_almacenes cuentas_almacenes
                                    ON (items_1.id_almacen = cuentas_almacenes.id_almacen))
                                LEFT OUTER JOIN dbo.almacenes almacenes
                                   ON (items_1.id_almacen = almacenes.id_almacen))
                               INNER JOIN
                               dbo.transacciones transacciones_2
                                  ON (transacciones_2.id_transaccion = transacciones.id_antecedente)
                         WHERE (items_1.id_almacen > 0) AND transacciones.id_transaccion = @id_transaccion
                        GROUP BY 
                                 TipoTran.Descripcion,
                                 items_1.id_concepto,
                                 cuentas_almacenes.cuenta,
                                 almacenes.descripcion
                             ,transacciones.referencia;
                        
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos a almacen registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosAlmacenesDesdeItems]');
    }
}
