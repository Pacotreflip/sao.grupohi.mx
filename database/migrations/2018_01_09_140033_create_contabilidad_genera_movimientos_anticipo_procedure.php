<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraMovimientosAnticipoProcedure extends Migration
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
                        CREATE PROCEDURE [Contabilidad].[generaMovimientosAnticipo] 
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
                            ,id_empresa_cadeco
                            ,[concepto]
                                ,[importe]
                                ,[timestamp]
                            ,[created_at]
                            ,[usuario_registro]
                            ,referencia
                            )
                               
                                SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  0,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    0,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 19 THEN 1
                                  WHEN 33 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO*  \' + empresas.razon_social, 100) as concepto,
                               sum (items_1.importe * items_1.anticipo  / 100) AS importe,
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
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                               INNER JOIN dbo.items items_1
                                  ON (items.item_antecedente = items_1.id_item) 
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                         WHERE (transacciones.id_transaccion = @id_transaccion) and transacciones.id_moneda = 1
                         
                         GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             transacciones.id_moneda,
                           transacciones.referencia
                        having sum (items_1.importe * items_1.anticipo / 100)>0
                         
                         UNION 
                         
                          SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  0,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    0,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 19 THEN 1
                                  WHEN 33 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO USD*  \' + empresas.razon_social, 100) as concepto,
                               sum (items_1.importe * items_1.anticipo  / 100) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro
                              ,transacciones.referencia
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                               INNER JOIN dbo.items items_1
                                  ON (items.item_antecedente = items_1.id_item) 
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                         WHERE (transacciones.id_transaccion = @id_transaccion) and transacciones.id_moneda = 2
                        
                        GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             transacciones.id_moneda,
                           transacciones.referencia
                        having sum (items_1.importe * items_1.anticipo / 100)>0
                        union
                        SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  1,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    1,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 19 THEN 1
                                  WHEN 33 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO COMPLEMENTARIA*  \' + empresas.razon_social, 100) as concepto,
                               sum (((items_1.importe * items_1.anticipo / 100 * 
                             
                             CASE transacciones_1.tipo_transaccion
                                  WHEN 19 THEN transacciones.tipo_cambio -- tipo de cambio de la PRESENTE factura de anticipo
                                  WHEN 33 THEN  Contabilidad.udfObtieneTipoCambioAmortizacionAnticipo(items.item_antecedente) --tipo de cambio tomado de factura de anticipo para amortización
                               END
                             
                             )-(items_1.importe * items_1.anticipo / 100))) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              @usuario_registro
                              ,transacciones.referencia
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                               INNER JOIN dbo.items items_1
                                  ON (items.item_antecedente = items_1.id_item) 
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                         WHERE (transacciones.id_transaccion = @id_transaccion) and transacciones.id_moneda = 2
                        
                        GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             transacciones.id_moneda,
                           transacciones.referencia
                        having sum (items_1.importe * items_1.anticipo / 100)>0
                        UNION
                        
                        SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  0,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    0,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 51 THEN 1
                                  WHEN 52 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO **  \' + empresas.razon_social, 100) as concepto,
                               sum ((items_1.importe) * transacciones_1.anticipo  / 100) AS importe,
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
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                          INNER JOIN dbo.items items_1
                                   ON (items_1.id_transaccion = transacciones_1.id_transaccion)
                         WHERE (transacciones.id_transaccion = @id_transaccion) 
                         and transacciones.id_moneda = 1
                         
                         GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             transacciones.id_moneda,
                           transacciones.referencia
                          having sum ((transacciones_1.monto-transacciones_1.impuesto) * transacciones_1.anticipo  / 100)>0
                        
                          --UNION
                        
                        --SELECT 
                        --      @id_int_poliza,
                        --      Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                        --          transacciones.id_transaccion,
                        --          0,
                        --          transacciones.id_moneda,
                        --          0,
                        --          1)
                        --          AS id_tipo_cuenta_contable,
                        --       Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                        --                                         transacciones.id_empresa,
                        --                                         0,
                        --                                         Contabilidad.udfGetTipoCuentaEmpresa (
                        --                                            transacciones.id_transaccion,
                        --                                            0,
                        --                                            transacciones.id_moneda,
                        --                                            0,
                        --                                            1))
                        --          AS cuenta_contable,
                        --       CASE transacciones_1.tipo_transaccion
                        --          WHEN 51 THEN 1
                        --          WHEN 52 THEN 2
                        --       END
                        --          AS id_tipo_movimiento_poliza,
                        --        LEFT (\'* ANTICIPO *  \' + empresas.razon_social, 100) as concepto,
                        --       sum ((transacciones_1.monto-transacciones_1.impuesto) * transacciones_1.anticipo  / 100) AS importe,
                        --         CONVERT (VARCHAR (10), GETDATE (), 121)
                        --       + \' \'
                        --       + CONVERT (VARCHAR (8), GETDATE (), 108)
                        --          AS [timestamp],
                        --         CONVERT (VARCHAR (10), GETDATE (), 121)
                        --       + \' \'
                        --       + CONVERT (VARCHAR (8), GETDATE (), 108)
                        --          AS created_at,
                        --      @usuario_registro,
                        --      transacciones.referencia
                        --  FROM ((dbo.items items
                        --         INNER JOIN
                        --         dbo.transacciones transacciones_1
                        --            ON (items.id_antecedente = transacciones_1.id_transaccion))
                        --        INNER JOIN
                        --        dbo.transacciones transacciones
                        --           ON (transacciones.id_transaccion = items.id_transaccion))
                        --     INNER JOIN dbo.empresas empresas
                        --           ON (transacciones.id_empresa = empresas.id_empresa)
                        -- WHERE (transacciones.id_transaccion = @id_transaccion) 
                        -- and transacciones.id_moneda = 1
                         
                        -- GROUP BY transacciones.id_transaccion,
                        --         transacciones.id_obra,
                        --         transacciones.id_empresa,
                        --     transacciones_1.tipo_transaccion,
                        --     empresas.razon_social,
                        --     transacciones.id_moneda,
                        --   transacciones.referencia
                        --  having sum ((transacciones_1.monto-transacciones_1.impuesto) * transacciones_1.anticipo  / 100)>0
                          
                          UNION
                        
                        SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  0,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    0,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 51 THEN 1
                                  WHEN 52 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO USD **  \' + empresas.razon_social, 100) as concepto,
                                sum ((items_1.importe) * transacciones_1.anticipo  / 100) AS importe,
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
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                               INNER JOIN dbo.items items_1
                                   ON (items_1.id_transaccion = transacciones_1.id_transaccion)
                         WHERE (transacciones.id_transaccion = @id_transaccion) 
                         and transacciones.id_moneda = 2
                         
                         GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             transacciones.id_moneda,
                           transacciones.referencia
                          having sum ((transacciones_1.monto-transacciones_1.impuesto) * transacciones_1.anticipo  / 100)>0
                        
                          UNION
                        
                        SELECT 
                              @id_int_poliza,
                              Contabilidad.udfGetTipoCuentaEmpresaGeneral (
                                  transacciones.id_transaccion,
                                  0,
                                  transacciones.id_moneda,
                                  0,
                                  1)
                                  AS id_tipo_cuenta_contable,
                               Contabilidad.udfGetCuentaEmpresa (transacciones.id_obra,
                                                                 transacciones.id_empresa,
                                                                 0,
                                                                 Contabilidad.udfGetTipoCuentaEmpresa (
                                                                    transacciones.id_transaccion,
                                                                    0,
                                                                    transacciones.id_moneda,
                                                                    0,
                                                                    1))
                                  AS cuenta_contable,
                               CASE transacciones_1.tipo_transaccion
                                  WHEN 51 THEN 1
                                  WHEN 52 THEN 2
                               END
                                  AS id_tipo_movimiento_poliza,
                              transacciones.id_empresa,
                                LEFT (\'*ANTICIPO COMPLEMENTARIA **  \' + empresas.razon_social, 100) as concepto,
                               
                        
                             -----
                            sum ((((items_transaccion.importe) * transacciones_1.anticipo / 100 * 
                             
                             CASE transacciones_1.tipo_transaccion
                                  WHEN 51 THEN transacciones.tipo_cambio -- tipo de cambio de la PRESENTE factura de anticipo
                                  WHEN 52 THEN  Contabilidad.udfObtieneTipoCambioAmortizacionAnticipoSubcontrato(items.id_antecedente) --tipo de cambio tomado de factura de anticipo del subcontrato para amortización
                               END
                            
                             ) 
                         ))-sum((items_transaccion.importe) * transacciones_1.anticipo / 100) AS importe,
                             -----
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
                          FROM ((dbo.items items
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (items.id_antecedente = transacciones_1.id_transaccion))
                                INNER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                             INNER JOIN dbo.empresas empresas
                                   ON (transacciones.id_empresa = empresas.id_empresa)
                               INNER JOIN dbo.items items_transaccion
                                   ON (items_transaccion.id_transaccion = transacciones_1.id_transaccion)
                         WHERE (transacciones.id_transaccion = @id_transaccion) 
                         and transacciones.id_moneda = 2
                         
                         GROUP BY transacciones.id_transaccion,
                                 transacciones.id_obra,
                                 transacciones.id_empresa,
                             transacciones_1.tipo_transaccion,
                             empresas.razon_social,
                             
                             transacciones.id_moneda,
                           transacciones.referencia
                          having sum ((transacciones_1.monto-transacciones_1.impuesto) * transacciones_1.anticipo  / 100)>0
                          ;
                        
                         SELECT @cantidad_movimientos = @@ROWCOUNT;
                        
                         PRINT \'Movimientos de anticipo registrados:\' +   CAST( @cantidad_movimientos AS VARCHAR(10) );
                        
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaMovimientosAnticipo]');
    }
}
