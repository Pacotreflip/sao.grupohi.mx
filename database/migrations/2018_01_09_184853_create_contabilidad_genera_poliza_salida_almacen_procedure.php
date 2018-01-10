<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaSalidaAlmacenProcedure extends Migration
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
                        CREATE PROCEDURE [Contabilidad].[generaPolizaSalidaAlmacen] 
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
                               390 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               transacciones.id_obra AS id_obra_cadeco,
                               transacciones.id_transaccion AS id_transaccion_sao,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               transacciones.fecha,
                        
                             LEFT(\'*SA # \' + cast(transacciones.numero_folio as varchar(10))+\'* (\' + isnull(transacciones.observaciones,\'\')+\')\', 100) AS concepto,
                               SUM (movimientos.monto_total) AS importe,
                             GETDATE(),
                             GETDATE(),
                             180 as registro,
                             0 as cuadre,
                             transacciones.comentario as usuario_registro,
                             -1 as estatus
                          FROM ((dbo.items items
                                 INNER JOIN dbo.movimientos movimientos
                                    ON (items.id_item = movimientos.id_item))
                                RIGHT OUTER JOIN
                                dbo.transacciones transacciones
                                   ON (transacciones.id_transaccion = items.id_transaccion))
                               LEFT OUTER JOIN
                               Contabilidad.datos_contables_obra datos_contables_obra
                                  ON (transacciones.id_obra = datos_contables_obra.id_obra)
                         WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones.tipo_transaccion = 34)
                               AND (transacciones.opciones = 1)
                             AND transacciones.id_transaccion not in(select id_transaccion_sao from Contabilidad.int_polizas WHERE id_transaccion_sao is not null )
                        GROUP BY transacciones.id_obra,
                                 transacciones.id_transaccion,
                                 datos_contables_obra.NumobraContPaq,
                                 datos_contables_obra.BDContPaq,
                                 transacciones.fecha,
                                 transacciones.observaciones,
                                 transacciones.tipo_transaccion,
                                 transacciones.comentario,
                             transacciones.numero_folio
                        
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
                        
                        PRINT \'Pólizas de salidas de almacén registradas: \' + 
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
                                   ,[timestamp]
                               ,[created_at]
                               , id_transaccion_sao
                               ,usuario_registro
                                   )
                        
                               --AFECTACIÓN COSTO
                        SELECT 
                        @id,
                        1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta AS cuenta_contable,
                               SUM (movimientos.monto_total) AS importe,
                               1 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*CONCEPTO* \' + conceptos.[descripcion], 100) AS concepto,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                               transacciones.id_transaccion,
                               transacciones.comentario AS usuario_registro
                          FROM (((dbo.items items
                                  INNER JOIN dbo.movimientos movimientos
                                     ON (items.id_item = movimientos.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                INNER JOIN dbo.conceptos conceptos
                                   ON (items.id_concepto = conceptos.id_concepto))
                               LEFT OUTER JOIN
                               (SELECT cuentas_conceptos.id,
                                       cuentas_conceptos.id_concepto,
                                       cuentas_conceptos.cuenta
                                  FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                              where (cuentas_conceptos.deleted_at IS NULL) AND cuentas_conceptos.estatus = 1)
                               Subquery
                                  ON (conceptos.id_concepto = Subquery.id_concepto)
                         WHERE (transacciones.id_transaccion = @id_transaccion and items.id_concepto > 0)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 Subquery.cuenta,
                                 conceptos.descripcion,
                                 transacciones.comentario
                        UNION
                           
                        --AFECTACIÓN ALMACEN ENTRADA
                        SELECT 
                        @id,
                        29 AS id_tipo_cuenta_contable,
                               Subquery.cuenta AS cuenta_contable,
                               SUM (movimientos.monto_total) AS importe,
                               1 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*ALM. ENT.* \' + almacenes.[descripcion], 100) AS concepto,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                               transacciones.id_transaccion,
                               transacciones.comentario AS usuario_registro
                          FROM (((dbo.items items
                                  INNER JOIN dbo.movimientos movimientos
                                     ON (items.id_item = movimientos.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                 INNER JOIN dbo.almacenes almacenes
                                   ON (items.id_almacen = almacenes.id_almacen))
                               LEFT OUTER JOIN
                               (SELECT cuentas_almacenes.id,
                                       cuentas_almacenes.id_almacen,
                                       cuentas_almacenes.cuenta
                                  FROM Contabilidad.cuentas_almacenes cuentas_almacenes
                              WHERE cuentas_almacenes.estatus = 1)
                               Subquery
                                  ON (almacenes.id_almacen = Subquery.id_almacen)
                         WHERE (transacciones.id_transaccion = @id_transaccion and items.id_almacen > 0)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones.referencia,
                                 transacciones.observaciones,
                                 Subquery.cuenta,
                                 almacenes.descripcion,
                                 transacciones.comentario
                        UNION
                                    
                        --MOVIMIENTOS ALMACENES SALIDA
                        
                        SELECT 
                        @id,
                        29 AS id_tipo_cuenta_contable,
                               Subquery.cuenta AS cuenta_contable,
                               SUM (movimientos.monto_total) AS importe,
                               2 AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                               LEFT (\'*ALM. SAL.* \' + almacenes.[descripcion], 100) AS concepto,
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                               CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS created_at,
                               transacciones.id_transaccion,
                               transacciones.comentario AS usuario_registro
                          FROM ((((dbo.inventarios inventarios
                                   INNER JOIN
                                   dbo.movimientos movimientos
                                      ON (inventarios.id_lote = movimientos.lote_antecedente))
                                  INNER JOIN dbo.items items
                                     ON (items.id_item = movimientos.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                INNER JOIN dbo.almacenes almacenes
                                   ON (transacciones.id_almacen = almacenes.id_almacen))
                               LEFT OUTER JOIN
                               (SELECT cuentas_almacenes.id,
                                       cuentas_almacenes.id_almacen,
                                       cuentas_almacenes.cuenta
                                  FROM Contabilidad.cuentas_almacenes cuentas_almacenes
                              WHERE cuentas_almacenes.estatus = 1)
                               Subquery
                                  ON (almacenes.id_almacen = Subquery.id_almacen)
                         WHERE (transacciones.id_transaccion = @id_transaccion)
                        GROUP BY transacciones.id_transaccion,
                                 transacciones.referencia,
                                 Subquery.cuenta,
                                 transacciones.comentario,
                                 almacenes.descripcion
                        
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
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaSalidaAlmacen]');
    }
}
