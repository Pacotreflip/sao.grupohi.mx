<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaReembolsoProcedure extends Migration
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
                        -- Create date: 30/08/2017
                        -- Description: Procedimiento almancenado para generar una póliza a partir de una 
                        -- transaccion de reembolso de fondo fijo (101) dado
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaReembolso] 
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
                          @cuentas_faltantes INT,
                          @usuario_registro VARCHAR(1024);
                          
                          SELECT @usuario_registro = comentario from 
                          transacciones
                          WHERE id_transaccion = @id_transaccion
                        
                        
                        
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
                               400 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               transacciones.id_obra AS id_obra_cadeco,
                               transacciones.id_transaccion AS id_transaccion_sao,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               transacciones.fecha,
                             \'*RG#\' + cast(transacciones.numero_folio as varchar(10))+\'* \' +isnull(fondos.descripcion,\'\')+\' (\' +isnull(transacciones.observaciones,\'\')+\')\' AS concepto,
                               sum( transacciones.monto) as importe,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             1 as registro,
                             0 as cuadre,
                             transacciones.comentario as usuario_registro,
                             -1 as estatus
                          FROM (dbo.transacciones transacciones --reembolso de fondo fijo (101)
                          LEFT OUTER JOIN dbo.fondos fondos on(fondos.id_fondo = transacciones.id_referente)
                                 
                               LEFT OUTER JOIN
                               Contabilidad.datos_contables_obra datos_contables_obra
                                ON (transacciones.id_obra = datos_contables_obra.id_obra) )
                                 
                           WHERE     (transacciones.id_transaccion = @id_transaccion)
                               AND (transacciones.tipo_transaccion = 101)
                               AND transacciones.id_transaccion not in(select id_transaccion_sao from Contabilidad.int_polizas where id_transaccion_sao is not null)
                           GROUP BY transacciones.id_obra,
                                 transacciones.id_transaccion,
                                 datos_contables_obra.NumobraContPaq,
                                 datos_contables_obra.BDContPaq,
                                 transacciones.fecha,
                                 transacciones.observaciones,
                                 transacciones.tipo_transaccion,
                             transacciones.numero_folio,
                             transacciones.comentario,
                             fondos.descripcion; 
                        
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
                        
                        PRINT \'Pólizas de reembolsos registradas: \' + 
                          CAST( @cuentaTran AS VARCHAR(10) );
                        END
                        
                        
                        --GENERACIÓN DE PARTIDAS DE PÓLIZA
                        
                        INSERT INTO [Contabilidad].[int_polizas_movimientos]
                                   ([id_int_poliza]
                                   ,[id_tipo_cuenta_contable]
                                   ,[cuenta_contable]
                                   ,[id_tipo_movimiento_poliza]
                               ,[concepto]
                               ,[importe]
                                   ,[timestamp]
                               ,[created_at]
                               ,[referencia]
                               ,usuario_registro
                                   )
                        
                               SELECT 
                               @id,
                               1 AS id_tipo_cuenta_contable,
                               Subquery.cuenta,
                               1 AS id_tipo_movimiento_poliza,
                               LEFT (
                                    isnull (transacciones.observaciones, \'\')
                                  + \' *CONCEPTO* \'
                                  + conceptos_1.descripcion
                                  + \'->\'
                                  + conceptos.descripcion,
                                  3900)
                                  AS concepto,
                               SUM (items.importe) AS importe,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.referencia,
                             transacciones.comentario
                          FROM (((dbo.items items
                                  INNER JOIN dbo.conceptos conceptos
                                     ON (items.id_concepto = conceptos.id_concepto))
                                 INNER JOIN dbo.transacciones transacciones
                                    ON (transacciones.id_transaccion = items.id_transaccion))
                                LEFT OUTER JOIN
                                (SELECT cuentas_conceptos.id_concepto,
                                        cuentas_conceptos.cuenta,
                                        cuentas_conceptos.deleted_at,
                                        cuentas_conceptos.estatus
                                   FROM Contabilidad.cuentas_conceptos cuentas_conceptos
                                  WHERE     (cuentas_conceptos.deleted_at IS NULL)
                                        AND (cuentas_conceptos.estatus = 1)) Subquery
                                   ON (conceptos.id_concepto = Subquery.id_concepto))
                               LEFT OUTER JOIN dbo.conceptos conceptos_1
                                  ON     (substring (conceptos.nivel, 1, len (conceptos.nivel) - 4) =
                                             conceptos_1.nivel)
                                     AND (conceptos.id_obra = conceptos_1.id_obra)
                         WHERE (transacciones.id_transaccion = @id_transaccion)
                        GROUP BY transacciones.id_transaccion,
                                 conceptos.descripcion,
                                 Subquery.cuenta,
                                 substring (conceptos.nivel, 1, len (conceptos.nivel) - 4),
                                 conceptos_1.descripcion,
                                 transacciones.observaciones,
                                 transacciones.referencia,
                             transacciones.comentario
                        UNION
                        SELECT 
                        @id,
                        23 AS id_tipo_cuenta_contable,
                               Contabilidad.[udfObtieneCuentaContableGeneral] (transacciones.id_obra,
                                                                               23)
                                  AS cuenta_contable,
                               1 AS id_tipo_movimiento_poliza,
                               isnull (transacciones.observaciones, \'\') + \' *IVA*\' AS concepto,
                               transacciones.impuesto,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.referencia,
                             transacciones.comentario
                          FROM dbo.transacciones transacciones
                         WHERE (transacciones.id_transaccion = @id_transaccion) AND (transacciones.impuesto > 0)
                        UNION
                        SELECT 
                        @id,
                        CASE WHEN SUBSTRING (descripcion, 1, 3) = \'RDG\' THEN 54 ELSE 55 END
                                  AS id_tipo_cuenta_contable,
                               fondos.cuenta_contable,
                               2 AS id_tipo_movimiento_poliza,
                               isnull (transacciones.observaciones, \'\') + \' \' + fondos.descripcion
                                  AS concepto,
                               transacciones.monto,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               transacciones.referencia,
                             transacciones.comentario
                          FROM dbo.transacciones transacciones
                               INNER JOIN dbo.fondos fondos
                                  ON (transacciones.id_referente = fondos.id_fondo)
                         WHERE (transacciones.id_transaccion = @id_transaccion)
                               
                        
                        
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
                        
                          if @cuentas_faltantes > 0 OR abs(@cuadre) > 0.99
                          begin
                            update Contabilidad.int_polizas set estatus = -1 where id_int_poliza = @id;
                          end
                          else
                          begin
                            update Contabilidad.int_polizas set estatus = 0 where id_int_poliza = @id;
                          end
                        
                          update Contabilidad.int_polizas set total = (
                          SELECT  (total.importe) AS importe
                          FROM (select sum(importe) as importe from int_polizas_movimientos where id_int_poliza = @id and id_tipo_movimiento_poliza = 1) as total)
                          WHERE id_int_poliza = @id;
                        
                        
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
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaReembolso]');
    }
}
