<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosFondoGarantiaProcedure extends Migration
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
                        -- Create date: 31/07/2017
                        -- Description: Procedimiento para registrar movimientos de 
                        -- Fondo de Garantía registrados desde el módulo de estimaciones 
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosFondoGarantia] 
                          @id_int_poliza INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                          DECLARE @id_transaccion INT,
                          @usuario_registro VARCHAR(1024),
                          @cantidad_movimientos INT,
                          @importe FLOAT
                        
                          SELECT @id_transaccion = id_transaccion_sao from 
                          Contabilidad.int_polizas
                          WHERE id_int_poliza = @id_int_poliza
                        
                          SELECT @usuario_registro = comentario from 
                          transacciones
                          WHERE id_transaccion = @id_transaccion
                        
                          SELECT @importe = [Contabilidad].[udfObtieneFondoGarantia](@id_transaccion)
                        
                        
                          INSERT INTO [Contabilidad].[int_polizas_movimientos]
                                ([id_int_poliza]
                                ,[id_tipo_cuenta_contable]
                                ,[cuenta_contable]
                            ,[id_tipo_movimiento_poliza]
                            ,[id_empresa_cadeco]
                            ,[concepto]
                                ,[importe]
                                ,[timestamp]
                            ,[created_at]
                            ,[usuario_registro]
                            ,[referencia]
                            )
                               select * from(
                        
                              SELECT 
                               @id_int_poliza AS id_int_poliza,
                               Contabilidad.udfGetTipoCuentaEmpresaGeneral(
                                  transacciones.id_transaccion,
                                  1,
                                  transacciones.id_moneda,
                                  0,
                              0
                                ) AS id_tipo_cuenta_contable,
                              Contabilidad.udfGetCuentaEmpresa(
                                transacciones.id_obra,
                                transacciones.id_empresa,
                                1,
                                Contabilidad.udfGetTipoCuentaEmpresa(
                                  transacciones.id_transaccion,
                                  1,
                                  transacciones.id_moneda,
                                  0,
                                  0
                                )
                              ) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                             empresas.id_empresa,
                               left (
                                    \'*\'
                                  + int_tipos_cuentas_contables.descripcion
                                  + \'* \'
                                  + empresas.razon_social,
                                  100) AS concepto,
                                 @importe AS importe,
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [created_at],
                            @usuario_registro as usuario_registro,
                            transacciones.referencia
                          FROM dbo.transacciones transacciones 
                          INNER JOIN dbo.empresas empresas
                                  ON (transacciones.id_empresa = empresas.id_empresa)
                        LEFT JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON (Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                          transacciones.id_transaccion,
                                          1,
                                          transacciones.id_moneda,
                                          0,
                                          0) = int_tipos_cuentas_contables.id_tipo_cuenta_contable)
                         WHERE transacciones.id_transaccion = @id_transaccion AND transacciones.id_moneda = 1
                         AND @importe >0.01
                        
                         UNION
                        
                         SELECT 
                               @id_int_poliza AS id_int_poliza,
                               38 AS id_tipo_cuenta_contable,
                              Contabilidad.udfGetCuentaEmpresa(
                                transacciones.id_obra,
                                transacciones.id_empresa,
                                1,
                                11
                              ) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                             empresas.id_empresa,
                               left (
                                    \'*\'
                                  + int_tipos_cuentas_contables.descripcion
                                  + \'* \'
                                  + empresas.razon_social,
                                  100) AS concepto,
                                 [Contabilidad].[udfObtieneFondoGarantia](@id_transaccion)
                               
                                  AS importe,
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [created_at],
                            @usuario_registro as usuario_registro,
                            transacciones.referencia
                          FROM dbo.transacciones transacciones 
                          INNER JOIN dbo.empresas empresas
                                  ON (transacciones.id_empresa = empresas.id_empresa)
                        LEFT JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON (38 = int_tipos_cuentas_contables.id_tipo_cuenta_contable)
                         WHERE transacciones.id_transaccion = @id_transaccion AND transacciones.id_moneda = 2 AND @importe >0.01
                        
                         UNION
                        
                         SELECT 
                               @id_int_poliza AS id_int_poliza,
                               39 AS id_tipo_cuenta_contable,
                              Contabilidad.udfGetCuentaEmpresa(
                                transacciones.id_obra,
                                transacciones.id_empresa,
                                1,
                                12
                              ) AS cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                             empresas.id_empresa,
                               left (
                                    \'*\'
                                  + int_tipos_cuentas_contables.descripcion
                                  + \'* \'
                                  + empresas.razon_social,
                                  100) AS concepto,
                                 ((@importe * transacciones.tipo_cambio) - @importe) AS importe,
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                              CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [created_at],
                            @usuario_registro as usuario_registro,
                            transacciones.referencia
                          FROM dbo.transacciones transacciones 
                          INNER JOIN dbo.empresas empresas
                                  ON (transacciones.id_empresa = empresas.id_empresa)
                        LEFT JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON (39 = int_tipos_cuentas_contables.id_tipo_cuenta_contable)
                         WHERE transacciones.id_transaccion = @id_transaccion AND transacciones.id_moneda = 2 AND @importe >0.01
                        
                            
                         ) as tabla
                         WHERE tabla.importe>0;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos Fondo de Garantía Registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosFondoGarantia]');
    }
}
