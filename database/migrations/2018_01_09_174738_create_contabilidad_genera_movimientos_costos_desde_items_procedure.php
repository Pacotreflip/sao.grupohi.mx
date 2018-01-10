<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosCostosDesdeItemsProcedure extends Migration
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
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosCostosDesdeItems] 
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
                        1 as id_tipo_cuenta_contable,
                        cuentas_conceptos.cuenta,
                        1 AS [id_tipo_movimiento_poliza],
                        LEFT(\'*CONCEPTO* \'
                         + conceptos_1.descripcion
                                  + \'->\'
                                  + conceptos.descripcion+\' (\'
                         + TipoTran.Descripcion+ CAST(transacciones_3.numero_folio as varchar(8))+\')\', 100)
                        
                                  AS concepto,
                                  sum (items.precio_unitario * items.cantidad * transacciones.tipo_cambio) AS importe,
                                  CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [created_at],
                            @usuario_registro,
                            transacciones.referencia
                              
                               
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
                                 Contabilidad.cuentas_conceptos cuentas_conceptos
                                    ON (items_1.id_concepto = cuentas_conceptos.id_concepto))
                                LEFT OUTER JOIN dbo.conceptos conceptos
                                   ON (items_1.id_concepto = conceptos.id_concepto))
                               INNER JOIN
                               dbo.transacciones transacciones_2
                                  ON (transacciones_2.id_transaccion = transacciones.id_antecedente)
                              INNER JOIN dbo.conceptos conceptos_1
                                  ON     (substring (conceptos.nivel, 1, len (conceptos.nivel) - 4) =
                                             conceptos_1.nivel)
                                     AND (conceptos.id_obra = conceptos_1.id_obra)
                         WHERE (items_1.id_concepto > 0) AND transacciones.id_transaccion = @id_transaccion
                        GROUP BY 
                                 TipoTran.Descripcion,
                                 items_1.id_concepto,
                                 cuentas_conceptos.cuenta,
                                 conceptos.descripcion,
                             conceptos_1.descripcion,
                                 transacciones_3.numero_folio,
                             transacciones.referencia;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                         
                         
                         /*
                         * genera relación de costos y movimientos
                         */
                         
                         INSERT INTO Contabilidad.int_polizas_movimientos_costos(
                           id_int_poliza_movimiento
                          ,id_concepto
                          ,id_moneda
                          ,importe
                        ) 
                        
                        SELECT Subquery.id_int_poliza_movimiento,
                               items_origen_costo.id_concepto,
                               transacciones_factura.id_moneda,
                               sum (
                                    items_factura.precio_unitario
                                  * items_factura.cantidad
                                  * transacciones_factura.tipo_cambio)
                                  AS importe_costo
                          FROM (((((dbo.items items_origen_costo
                                    INNER JOIN
                                    dbo.transacciones transacciones_origen_costo
                                       ON (items_origen_costo.id_transaccion =
                                              transacciones_origen_costo.id_transaccion))
                                   INNER JOIN dbo.items items_factura
                                      ON     (items_factura.id_antecedente =
                                                 transacciones_origen_costo.id_transaccion)
                                         AND (items_factura.item_antecedente =
                                                 items_origen_costo.id_item))
                                  INNER JOIN
                                  dbo.transacciones transacciones_factura
                                     ON (transacciones_factura.id_transaccion =
                                            items_factura.id_transaccion))
                                 INNER JOIN
                                 Contabilidad.int_polizas int_polizas
                                    ON (int_polizas.id_transaccion_sao =
                                           transacciones_factura.id_transaccion))
                                INNER JOIN
                                Contabilidad.cuentas_conceptos cuentas_conceptos
                                   ON (items_origen_costo.id_concepto = cuentas_conceptos.id_concepto))
                               INNER JOIN
                               (SELECT int_polizas_movimientos.cuenta_contable,
                                       int_polizas_movimientos.id_int_poliza_movimiento,
                                       int_polizas_movimientos.id_int_poliza,
                                       int_polizas_movimientos.importe,
                                       int_polizas_movimientos.id_tipo_cuenta_contable,
                                       int_polizas_movimientos.deleted_at
                                  FROM Contabilidad.int_polizas_movimientos int_polizas_movimientos
                                 WHERE     (int_polizas_movimientos.id_int_poliza = @id_int_poliza)
                                       AND (int_polizas_movimientos.importe >= 0)
                                       AND (int_polizas_movimientos.id_tipo_cuenta_contable = 1)
                                       AND (int_polizas_movimientos.deleted_at IS NULL)) Subquery
                                  ON (cuentas_conceptos.cuenta = Subquery.cuenta_contable)
                         WHERE     (items_origen_costo.id_concepto > 0)
                               AND (int_polizas.id_int_poliza = @id_int_poliza)
                               AND (transacciones_origen_costo.tipo_transaccion = 33)
                        GROUP BY int_polizas.id_int_poliza,
                                 items_origen_costo.id_concepto,
                                 cuentas_conceptos.cuenta,
                                 transacciones_factura.id_transaccion,
                                 transacciones_factura.tipo_cambio,
                                 transacciones_origen_costo.tipo_transaccion,
                                 cuentas_conceptos.id,
                                 Subquery.id_int_poliza_movimiento,
                                 transacciones_factura.id_moneda
                        
                         PRINT \'Movimientos a costos registrados:\' +  CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosCostosDesdeItems]');
    }
}
