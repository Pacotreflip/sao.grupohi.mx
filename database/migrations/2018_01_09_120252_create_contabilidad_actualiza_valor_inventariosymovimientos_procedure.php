<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadActualizaValorInventariosymovimientosProcedure extends Migration
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
                        CREATE PROCEDURE [Contabilidad].[actualizaValorInventariosyMovimientos]
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
                        
                          /*Poner tipo de cambio original de la entrada de almacén por inventario (entrada a almacén)*/
                          
                          UPDATE transacciones_1 set tipo_cambio =  (inventarios.monto_total) /  (items_1.importe)
                          FROM (((dbo.items items
                                  INNER JOIN dbo.items items_1
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items_1.id_transaccion = transacciones_1.id_transaccion))
                                INNER JOIN dbo.inventarios inventarios
                                   ON (items_1.id_item = inventarios.id_item))
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (transacciones.id_transaccion = items.id_transaccion)
                         WHERE     (transacciones_1.tipo_transaccion = 33)
                               AND (    transacciones_1.tipo_transaccion = 33
                                    AND transacciones.id_transaccion = @id_transaccion)
                        
                          /*Poner tipo de cambio original de la entrada de almacén por movimiento salida a costo directamente*/
                          
                          UPDATE transacciones_1 set tipo_cambio =  (movimientos.monto_total) /  (items_1.importe)
                          FROM (((dbo.items items
                                  INNER JOIN dbo.items items_1
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items_1.id_transaccion = transacciones_1.id_transaccion))
                                INNER JOIN dbo.movimientos movimientos
                                   ON (items_1.id_item = movimientos.id_item))
                               INNER JOIN
                               dbo.transacciones transacciones
                                  ON (transacciones.id_transaccion = items.id_transaccion)
                         WHERE     (transacciones_1.tipo_transaccion = 33)
                               AND (    transacciones_1.tipo_transaccion = 33
                                    AND transacciones.id_transaccion = @id_transaccion)
                        
                          /*Actualizar importe de inventarios*/
                        
                        update inventarios set monto_total = (inventarios.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                               , monto_original = (inventarios.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                          FROM (((dbo.items items
                                  INNER JOIN dbo.items items_1
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones_1
                                   ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                               INNER JOIN dbo.inventarios inventarios
                                  ON (items_1.id_item = inventarios.id_item)
                         WHERE (transacciones.id_transaccion = @id_transaccion AND transacciones_1.id_moneda != 1 );
                        
                         /*Actualizar importe de movimientos generados desde entrada*/
                        
                        update movimientos set monto_total = (movimientos.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                               , monto_original = (movimientos.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                        
                          FROM (((dbo.items items
                                  INNER JOIN dbo.items items_1
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones_1
                                   ON (transacciones_1.id_transaccion = items_1.id_transaccion))
                               INNER JOIN dbo.movimientos movimientos
                                  ON (items_1.id_item = movimientos.id_item)
                         WHERE (transacciones.id_transaccion = @id_transaccion AND transacciones_1.id_moneda != 1)
                        
                         /*Actualiza importe movimientos de inventario*/
                        
                         update movimientos set monto_total = (movimientos.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                               , monto_original = (movimientos.cantidad
                               * items_1.precio_unitario
                               * transacciones.tipo_cambio)
                         FROM ((((dbo.items items_1
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
                               INNER JOIN dbo.movimientos movimientos
                                  ON (inventarios.id_lote = movimientos.lote_antecedente)
                         WHERE (transacciones.id_transaccion = @id_transaccion AND transacciones_1.id_moneda != 1)
                        
                        
                         PRINT \'Actualización de inventarios y  movimientos:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[actualizaValorInventariosyMovimientos]');

    }
}
