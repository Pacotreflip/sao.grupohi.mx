<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaEntradaAlmacenProcedure extends Migration
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
                        -- Create date: 23/06/2017
                        -- Description: Procedimiento almancenado para generar una póliza a partir de una entrada de almacén dada
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaEntradaAlmacen] 
                          @id_transaccion INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                        
                          BEGIN TRANSACTION;
                        
                          DECLARE
                          @cuentaTran INT,
                          @Id INT,
                          @err INT,
                          @ERROR INT,
                          @cuadre FLOAT,
                          @cuentas_faltantes INT
                        
                          INSERT INTO int_polizas (
                          
                            id_tipo_poliza,
                            id_tipo_poliza_interfaz,
                            id_tipo_poliza_contpaq,
                            alias_bd_cadeco,
                            id_obra_cadeco,
                            id_transaccion_sao,
                            id_obra_contpaq,
                            alias_bd_contpaq,
                            fecha,
                            concepto,
                            total,
                            timestamp_registro,
                            created_at,
                            registro,
                            cuadre,
                            usuario_registro,
                            estatus
                          )
                          SELECT 2 AS id_tipo_poliza,
                               389 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               transacciones.id_obra AS id_obra_cadeco,
                               transacciones.id_transaccion AS id_transaccion_sao,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               transacciones.fecha,
                        
                             LEFT(\'*EA # \' + cast(transacciones.numero_folio as varchar(10))+\'* \'+empresas.razon_social +\' (\' +isnull(transacciones.observaciones,\'\')+\')\', 100) AS concepto,
                               case  when SUM(inventarios.monto_total) IS NOT null then SUM (inventarios.monto_total)*1.16 else SUM (movimientos.monto_total)*1.16 end importe,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             1 as registro,
                             0 as cuadre,
                             transacciones.comentario as usuario_registro,
                             -1 as estatus
                          FROM (dbo.transacciones transacciones
                              LEFT OUTER JOIN dbo.items items
                                 ON (transacciones.id_transaccion = items.id_transaccion)
                                 LEFT OUTER JOIN dbo.inventarios inventarios
                                    ON (inventarios.id_item = items.id_item)
                              LEFT OUTER JOIN dbo.movimientos movimientos
                                    ON (movimientos.id_item = items.id_item)
                                 )
                               LEFT OUTER JOIN
                               Contabilidad.datos_contables_obra datos_contables_obra
                                ON (transacciones.id_obra = datos_contables_obra.id_obra)
                                LEFT OUTER JOIN
                               empresas
                                ON (transacciones.id_empresa = empresas.id_empresa)
                           WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones.tipo_transaccion = 33)
                               AND transacciones.id_transaccion not in(select id_transaccion_sao from Contabilidad.int_polizas where id_transaccion_sao is not null )
                           GROUP BY transacciones.id_obra,
                                 transacciones.id_transaccion,
                                 datos_contables_obra.NumobraContPaq,
                                 datos_contables_obra.BDContPaq,
                                 transacciones.fecha,
                                 transacciones.observaciones,
                                 transacciones.tipo_transaccion,
                             transacciones.numero_folio,
                             transacciones.comentario,
                             empresas.razon_social; 
                        
                          SET @Id = SCOPE_IDENTITY();
                          SELECT  @err = @@ERROR,
                            
                            @cuentaTran = @@ROWCOUNT;
                        
                          IF (@Id is null)BEGIN SET @ERROR = 1  GOTO TratarError END
                        
                          PRINT \'rowcount\'+CAST( @cuentaTran AS VARCHAR(10) )+ \'Id: \' + 
                          CAST( @Id AS VARCHAR(10) )+\' error:\' +CAST( @err AS VARCHAR(10) ) ; 
                        IF @err <> 0
                            BEGIN
                            PRINT \'Error 1: \';
                                ROLLBACK TRANSACTION;
                                RETURN(1);
                            END
                        ELSE IF( @cuentaTran < 1 )
                          BEGIN
                          PRINT \'Error 2: \';
                            ROLLBACK TRANSACTION;
                            RETURN (1);
                          END
                        
                        PRINT \'Pólizas de entradas de almacén registradas: \' + 
                          CAST( @cuentaTran AS VARCHAR(10) );
                        END
                        
                        
                        --GENERACIÓN DE PARTIDAS DE PÓLIZA
                        
                        INSERT INTO [Contabilidad].[int_polizas_movimientos]
                                   ([id_int_poliza]
                                   ,[id_tipo_cuenta_contable]
                        
                                   ,[cuenta_contable]
                                   ,[importe]
                                   ,[id_tipo_movimiento_poliza]
                                   ,[referencia]
                                   ,[concepto]
                                   ,[id_empresa_cadeco]
                                   ,[razon_social]
                                   ,[rfc]
                                   ,[timestamp]
                               ,[created_at]
                               , id_transaccion_sao
                               , id_item_sao
                               ,usuario_registro
                                   )
                        
                               --MOVIMIENTO ALMACEN
                        SELECT 
                        @id,
                        29 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               SUM (inventarios.monto_total) AS importe,
                               1 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*ALM.* \' + almacenes.[descripcion], 100) AS concepto,
                               transacciones.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                               items.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                               
                          FROM ((((dbo.items items
                                   INNER JOIN
                                   dbo.transacciones transacciones
                                      ON (items.id_transaccion = transacciones.id_transaccion))
                                  INNER JOIN dbo.empresas empresas
                                     ON (transacciones.id_empresa = empresas.id_empresa))
                                 INNER JOIN dbo.inventarios inventarios
                                    ON (inventarios.id_item = items.id_item))
                                INNER JOIN dbo.almacenes almacenes
                                   ON (items.id_almacen = almacenes.id_almacen))
                               LEFT OUTER JOIN
                               (SELECT cuentas_almacenes.id,
                                       cuentas_almacenes.id_almacen,
                                       cuentas_almacenes.cuenta
                                  FROM Contabilidad.cuentas_almacenes cuentas_almacenes
                              WHERE cuentas_almacenes.estatus = 1)
                               Subquery
                                  ON (Subquery.id_almacen = almacenes.id_almacen)
                         WHERE items.id_transaccion = @id_transaccion 
                         AND items.id_almacen > 0 --asegurar que el item se haya mandado a almacén
                        GROUP BY items.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 transacciones.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 Subquery.cuenta,
                                 items.id_transaccion,
                                 transacciones.comentario,
                                 almacenes.descripcion
                        UNION
                        --MOVIMIENTO CONCEPTO
                        SELECT 
                        @id,
                        1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               SUM (movimientos.monto_total) AS importe,
                               1 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CONCEPTO.* \' + conceptos.[descripcion], 100) AS concepto,
                               transacciones.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                               items.id_transaccion,
                               NULL AS id_item,
                               transacciones.comentario AS usuario_registro
                               
                          FROM ((((dbo.items items
                                   INNER JOIN
                                   dbo.transacciones transacciones
                                      ON (items.id_transaccion = transacciones.id_transaccion))
                                  INNER JOIN dbo.empresas empresas
                                     ON (transacciones.id_empresa = empresas.id_empresa))
                                 INNER JOIN dbo.movimientos movimientos
                                     ON (items.id_item = movimientos.id_item))
                                 INNER JOIN dbo.conceptos conceptos
                                   ON (items.id_concepto = conceptos.id_concepto))
                               LEFT OUTER JOIN
                               (SELECT cuentas_conceptos.id,
                                       cuentas_conceptos.id_concepto,
                                       cuentas_conceptos.cuenta
                                  FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                              WHERE (cuentas_conceptos.deleted_at IS NULL) AND 
                              cuentas_conceptos.estatus = 1)
                               Subquery
                                  ON (Subquery.id_concepto = conceptos.id_concepto)
                         WHERE items.id_transaccion = @id_transaccion 
                         AND items.id_concepto > 0 --asegurar que el item se haya mandado a un concepto
                        GROUP BY items.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 transacciones.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 Subquery.cuenta,
                                 items.id_transaccion,
                                 transacciones.comentario,
                                 conceptos.descripcion
                        UNION
                           
                                  --MOVIMIENTO INVENTARIO 
                        --SELECT 
                        --@id,
                        --25 as id_tipo_cuenta_contable,
                        ----Subquery.id as id_cuenta_contable,
                        --Subquery.cuenta,
                        --SUM (inventarios.monto_total) AS importe,
                        --1 AS id_tipo_movimiento_poliza,
                        --transacciones.referencia,
                        --LEFT(\'*INV.* \' + materiales.[descripcion], 100) AS concepto,
                        --       --Subquery.id_tipo_cuenta_material,
                        --      -- tipos_cuentas_materiales.descripcion,
                        --transacciones.id_empresa,
                        --empresas.razon_social,
                        --empresas.rfc,
                        --GETDATE() as timestamp,
                        --GETDATE() as created_at,
                        --items.id_transaccion,
                        
                        --items.id_item,
                        --transacciones.comentario as usuario_registro
                        
                        --  FROM (((((dbo.transacciones transacciones
                        --  INNER JOIN dbo.items items
                        --             ON (items.id_transaccion = transacciones.id_transaccion)
                                     
                        --             INNER JOIN dbo.materiales materiales
                        --           ON     (items.id_material = materiales.id_material)
                                      
                                     
                        --            INNER JOIN dbo.empresas empresas
                        --               ON (transacciones.id_empresa = empresas.id_empresa))
                        --           LEFT OUTER JOIN
                        --           (SELECT cuentas_materiales.id,
                        --                   cuentas_materiales.id_obra,
                        --                   cuentas_materiales.id_material,
                        --                   cuentas_materiales.id_tipo_cuenta_material,
                        --                   cuentas_materiales.cuenta
                        --              FROM Contabilidad.cuentas_materiales cuentas_materiales
                        --             WHERE (cuentas_materiales.id_tipo_cuenta_material = 1)) Subquery
                        --              ON (transacciones.id_obra = Subquery.id_obra) AND (materiales.id_material = Subquery.id_material))
                        --          )
                        --         INNER JOIN dbo.inventarios inventarios
                        --            ON (inventarios.id_item = items.id_item))
                        --        )
                        --       LEFT OUTER JOIN
                        --       Contabilidad.tipos_cuentas_materiales tipos_cuentas_materiales
                        --          ON (Subquery.id_tipo_cuenta_material = tipos_cuentas_materiales.id)
                        -- WHERE (items.id_transaccion =  @id_transaccion)
                        --GROUP BY items.id_transaccion,
                        --         transacciones.referencia,
                        --         transacciones.observaciones,
                        --         transacciones.id_empresa,
                        --         empresas.razon_social,
                        --         empresas.rfc,
                        --         tipos_cuentas_materiales.descripcion,
                        --         Subquery.id_tipo_cuenta_material,
                        --         Subquery.cuenta,
                        --         materiales.[descripcion],
                        --         items.id_transaccion,
                        --items.id_item,
                        --transacciones.comentario
                        --UNION
                        --MOVIMIENTO IVA CON INVENTARIOS
                        SELECT 
                        @id,
                        23 as id_tipo_cuenta_contable,
                        int_cuentas_contables.cuenta_contable,
                        SUM (inventarios.monto_total) * .16 AS importe,
                        1 AS id_tipo_movimiento_poliza, 
                        transacciones.referencia,
                               LEFT(\'*IVA* \' + empresas.[razon_social], 100) AS concepto,
                               transacciones.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               
                        CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                        items.id_transaccion,
                        /*items.id_item,
                        transacciones.comentario as usuario_registro*/
                        null as id_item,
                        null as usuario_registro
                        --int_cuentas_contables.id_int_tipo_cuenta_contable,
                              -- int_tipos_cuentas_contables.descripcion,
                               
                               
                               
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.items items
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                  INNER JOIN dbo.inventarios inventarios
                                     ON (inventarios.id_item = items.id_item))
                                 INNER JOIN
                                 Contabilidad.int_cuentas_contables int_cuentas_contables
                                    ON (transacciones.id_obra = int_cuentas_contables.id_obra))
                                INNER JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON (int_cuentas_contables.id_int_tipo_cuenta_contable =
                                          int_tipos_cuentas_contables.id_tipo_cuenta_contable))
                               INNER JOIN dbo.empresas empresas
                                  ON (empresas.id_empresa = transacciones.id_empresa)
                         WHERE     (transacciones.id_transaccion =  @id_transaccion)
                               AND (int_cuentas_contables.id_int_tipo_cuenta_contable = 23) AND int_cuentas_contables.estatus = 1
                        GROUP BY transacciones.id_transaccion,
                                 int_cuentas_contables.cuenta_contable,
                                 int_cuentas_contables.id_int_tipo_cuenta_contable,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 transacciones.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 int_tipos_cuentas_contables.descripcion,
                                          items.id_transaccion
                        --items.id_item,
                        --transacciones.comentario
                        UNION
                        
                        --MOVIMIENTO IVA CON CONCEPTOS
                        SELECT 
                        @id,
                        23 as id_tipo_cuenta_contable,
                        int_cuentas_contables.cuenta_contable,
                        SUM (movimientos.monto_total)  * .16 AS importe,
                        1 AS id_tipo_movimiento_poliza, 
                        transacciones.referencia,
                               LEFT(\'*IVA* \' + empresas.[razon_social], 100) AS concepto,
                               transacciones.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               
                        CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                        items.id_transaccion,
                        /*items.id_item,
                        transacciones.comentario as usuario_registro*/
                        null as id_item,
                        null as usuario_registro
                        --int_cuentas_contables.id_int_tipo_cuenta_contable,
                              -- int_tipos_cuentas_contables.descripcion,
                               
                               
                               
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.items items
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                  INNER JOIN dbo.movimientos movimientos
                                     ON (movimientos.id_item = items.id_item))
                                 INNER JOIN
                                 Contabilidad.int_cuentas_contables int_cuentas_contables
                                    ON (transacciones.id_obra = int_cuentas_contables.id_obra))
                                INNER JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON (int_cuentas_contables.id_int_tipo_cuenta_contable =
                                          int_tipos_cuentas_contables.id_tipo_cuenta_contable))
                               INNER JOIN dbo.empresas empresas
                                  ON (empresas.id_empresa = transacciones.id_empresa)
                         WHERE     (transacciones.id_transaccion =  @id_transaccion)
                               AND (int_cuentas_contables.id_int_tipo_cuenta_contable = 23) AND int_cuentas_contables.estatus = 1
                        GROUP BY transacciones.id_transaccion,
                                 int_cuentas_contables.cuenta_contable,
                                 int_cuentas_contables.id_int_tipo_cuenta_contable,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 transacciones.id_empresa,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 int_tipos_cuentas_contables.descripcion,
                                          items.id_transaccion
                        --items.id_item,
                        --transacciones.comentario
                        UNION
                        
                        --MOVIMIENTO PROVEEDOR PESOS CON ENTRADA A ALMACEN Y CONCEPTOS
                        SELECT 
                        @id,
                        2 as id_tipo_cuenta_contable,
                        Subquery.cuenta AS cuenta_contable,
                          case  when sum(inventarios.monto_total) is not null then SUM (inventarios.monto_total)* 1.16 else SUM (movimientos.monto_total)* 1.16 END importe,
                               2 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT(\'*PROV.* \' + empresas.[razon_social], 100) AS concepto,
                                empresas.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as timestamp,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as created_at,
                               /*Subquery.id_tipo_cuenta_empresa,
                               tipos_cuentas_empresas.descripcion,*/
                               
                              
                               
                               transacciones.id_transaccion,
                               null as id_item,
                        null as usuario_registro
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.items items
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                  LEFT OUTER JOIN dbo.empresas empresas
                                     ON (transacciones.id_empresa = empresas.id_empresa))
                                 LEFT OUTER JOIN
                                 (SELECT cuentas_empresas.id,
                                         cuentas_empresas.id_obra,
                                         cuentas_empresas.id_empresa,
                                         cuentas_empresas.id_tipo_cuenta_empresa,
                                         cuentas_empresas.cuenta
                                    FROM Contabilidad.cuentas_empresas cuentas_empresas
                                   WHERE (cuentas_empresas.id_tipo_cuenta_empresa = 1) and cuentas_empresas.estatus = 1) Subquery
                                    ON     (Subquery.id_obra = transacciones.id_obra)
                                       AND (Subquery.id_empresa = empresas.id_empresa))
                                LEFT OUTER JOIN
                                Contabilidad.tipos_cuentas_empresas tipos_cuentas_empresas
                                   ON (Subquery.id_tipo_cuenta_empresa = tipos_cuentas_empresas.id))
                               LEFT JOIN dbo.inventarios inventarios
                                  ON (inventarios.id_item = items.id_item)
                              LEFT JOIN dbo.movimientos movimientos
                                  ON (movimientos.id_item = items.id_item)
                         WHERE (transacciones.id_transaccion =  @id_transaccion) AND (transacciones.id_moneda = 1)
                        GROUP BY empresas.id_empresa,
                                 transacciones.id_moneda,
                                 transacciones.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 tipos_cuentas_empresas.descripcion,
                                 Subquery.cuenta,
                                 Subquery.id_tipo_cuenta_empresa
                        UNION
                        --- MOVIMIENTO PROVEEDOR DOLARES
                        SELECT 
                        @id,
                        27 as id_tipo_cuenta_contable,
                        Subquery.cuenta AS cuenta_contable,
                        SUM (items.importe)  * 1.16 AS importe,
                               2 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT(\'*PROV. USD* \' + empresas.[razon_social], 100) AS concepto,
                                empresas.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as timestamp,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as created_at,
                               /*Subquery.id_tipo_cuenta_empresa,
                               tipos_cuentas_empresas.descripcion,*/
                        transacciones.id_transaccion,
                               null as id_item,
                        null as usuario_registro
                               
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.items items
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                    LEFT OUTER JOIN dbo.empresas empresas
                                    ON     (transacciones.id_empresa = empresas.id_empresa))
                                  LEFT OUTER JOIN
                                  (SELECT cuentas_empresas.id,
                                          cuentas_empresas.id_obra,
                                          cuentas_empresas.id_empresa,
                                          cuentas_empresas.id_tipo_cuenta_empresa,
                                          cuentas_empresas.cuenta
                                     FROM Contabilidad.cuentas_empresas cuentas_empresas
                                    WHERE cuentas_empresas.id_tipo_cuenta_empresa = 2 AND  cuentas_empresas.estatus = 1) Subquery
                                     ON (Subquery.id_obra = transacciones.id_obra) AND (Subquery.id_empresa = empresas.id_empresa))
                                 
                                LEFT OUTER JOIN
                                Contabilidad.tipos_cuentas_empresas tipos_cuentas_empresas
                                   ON (Subquery.id_tipo_cuenta_empresa = tipos_cuentas_empresas.id))
                               --LEFT JOIN dbo.inventarios inventarios
                               --   ON (inventarios.id_item = items.id_item)
                         WHERE (transacciones.id_transaccion =  @id_transaccion AND transacciones.id_moneda != 1)
                        GROUP BY empresas.id_empresa,
                                 transacciones.id_moneda,
                                 transacciones.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 tipos_cuentas_empresas.descripcion,
                                 Subquery.cuenta,
                                 Subquery.id_tipo_cuenta_empresa
                                 UNION 
                        --- MOVIMIENTO PROVEEDOR DOLARES COMPLEMENTARIA
                        SELECT 
                        @id,
                        28 as id_tipo_cuenta_contable,
                        Subquery.cuenta AS cuenta_contable,
                        
                          case when sum(inventarios.monto_total) is not null then (SUM (inventarios.monto_total)* 1.16 - SUM (items.importe) * 1.16)
                           else (SUM (movimientos.monto_total)* 1.16 - SUM (items.importe) * 1.16) END importe,
                        2 AS id_tipo_movimiento_poliza,
                        transacciones.referencia,
                               LEFT(\'*PROV. COMP.* \' + empresas.[razon_social], 100) AS concepto,
                               empresas.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as timestamp,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) as created_at,
                        
                        transacciones.id_transaccion,
                                      null as id_item,
                        null as usuario_registro
                               
                               /*Subquery.id_tipo_cuenta_empresa,
                               tipos_cuentas_empresas.descripcion,*/
                               
                               
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.items items
                                      ON (transacciones.id_transaccion = items.id_transaccion))
                                    LEFT OUTER JOIN dbo.empresas empresas
                                    ON     (transacciones.id_empresa = empresas.id_empresa))
                                  LEFT OUTER JOIN
                                  (SELECT cuentas_empresas.id,
                                          cuentas_empresas.id_obra,
                                          cuentas_empresas.id_empresa,
                                          cuentas_empresas.id_tipo_cuenta_empresa,
                                          cuentas_empresas.cuenta
                                     FROM Contabilidad.cuentas_empresas cuentas_empresas
                                    WHERE cuentas_empresas.id_tipo_cuenta_empresa = 3 AND  cuentas_empresas.estatus = 1) Subquery
                                     ON (Subquery.id_obra = transacciones.id_obra) AND (Subquery.id_empresa = empresas.id_empresa))
                                 
                                LEFT OUTER JOIN
                                Contabilidad.tipos_cuentas_empresas tipos_cuentas_empresas
                                   ON (Subquery.id_tipo_cuenta_empresa = tipos_cuentas_empresas.id))
                               LEFT JOIN dbo.inventarios inventarios
                                  ON (inventarios.id_item = items.id_item)
                              LEFT JOIN dbo.movimientos movimientos
                                  ON (movimientos.id_item = items.id_item)
                         WHERE (transacciones.id_transaccion =  @id_transaccion AND transacciones.id_moneda != 1)
                        GROUP BY empresas.id_empresa,
                                 transacciones.id_moneda,
                                 transacciones.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 empresas.razon_social,
                                 empresas.rfc,
                                 tipos_cuentas_empresas.descripcion,
                                 Subquery.cuenta,
                                 Subquery.id_tipo_cuenta_empresa;
                        
                             SELECT  @err = @@ERROR,
                            
                            @cuentaTran = @@ROWCOUNT;
                        
                        
                        
                        
                          IF @err <> 0
                            BEGIN
                            PRINT \'Error 3: \';
                                ROLLBACK TRANSACTION;
                                RETURN(1);
                            END
                        
                          PRINT \'Movimientos \' +CAST( @cuentaTran AS VARCHAR(10) );
                        
                          SET @cuadre =  Contabilidad.cuadrar_poliza(@id) ;
                          PRINT \'Cuadre \' +CAST( @cuadre AS VARCHAR(10) );
                          update Contabilidad.int_polizas set Cuadre = @cuadre where id_int_poliza = @id;
                        
                          select @cuentas_faltantes = count(*) from Contabilidad.int_polizas_movimientos where id_int_poliza = @id and cuenta_contable is null ;
                        
                          if @cuentas_faltantes > 0
                          begin
                            update Contabilidad.int_polizas set estatus = -1 where id_int_poliza = @id;
                          end
                          else
                          begin
                            update Contabilidad.int_polizas set estatus = 0 where id_int_poliza = @id;
                          end
                        
                        
                        COMMIT;
                        
                        TratarError:
                          IF @ERROR=1 
                          BEGIN 
                            PRINT \'Transacción registrada previamente\';
                                ROLLBACK TRANSACTION;
                                RETURN(1);
                            
                          END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaEntradaAlmacen]');
    }
}
