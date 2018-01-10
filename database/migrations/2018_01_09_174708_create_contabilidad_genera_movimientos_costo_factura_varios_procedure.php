<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosCostoFacturaVariosProcedure extends Migration
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
                        -- al costo originados de items de facturas de varios (numero 7)
                        -- =============================================
                          CREATE PROCEDURE [Contabilidad].[generaMovimientosCostoFacturaDeVarios] 
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
                           1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               \'FACTURA DE VARIOS\' AS descripcion,
                               SUM (items.importe) AS importe,
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro,
                              transacciones.referencia
                          FROM (((dbo.transacciones transacciones
                                  INNER JOIN dbo.monedas monedas
                                     ON (transacciones.id_moneda = monedas.id_moneda))
                                 INNER JOIN dbo.items items
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                LEFT OUTER JOIN
                                (SELECT cuentas_conceptos.id_concepto,
                                        cuentas_conceptos.id,
                                        cuentas_conceptos.cuenta,
                                        cuentas_conceptos.estatus
                                   FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                                  WHERE cuentas_conceptos.estatus = 1) Subquery
                                   ON (items.id_concepto = Subquery.id_concepto))
                               INNER JOIN dbo.monedas monedas_1
                                  ON (monedas_1.id_moneda = transacciones.id_moneda)
                         WHERE (transacciones.id_transaccion = @id_transaccion AND items.numero = 7)
                        GROUP BY items.numero,
                                 monedas.nombre,
                                 monedas_1.nombre,
                                 items.id_concepto,
                                 Subquery.cuenta,
                              transacciones.referencia;
                        
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos factura de varios registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosCostoFacturaDeVarios]');
    }
}
