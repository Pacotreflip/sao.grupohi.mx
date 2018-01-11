<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaMovimientosBancariosProcedure extends Migration
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
                        -- Create date: 23/11/2017
                        -- Description: Procedimiento almancenado para generar 
                        -- una póliza a partir de la transacción movimientos bancarios
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaMovimientosBancarios] 
                          @id_movimiento INT
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
                        
                          INSERT INTO Contabilidad.int_polizas (
                            id_tipo_poliza,
                            id_tipo_poliza_interfaz,
                            id_tipo_poliza_contpaq,
                            alias_bd_cadeco,
                            id_obra_cadeco, 
                            id_obra_contpaq, 
                            alias_bd_contpaq,
                            fecha,
                            concepto,
                            total,
                            timestamp_registro,
                            created_at,
                            registro,
                            usuario_registro,
                            estatus,
                            id_movimiento_bancario,
                            cuadre
                          )
                          SELECT 
                               2 AS id_tipo_poliza,
                               402 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               movimientos_bancarios.id_obra AS id_obra_cadeco,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               movimientos_bancarios.fecha,
                                 \'*MOV. BAN. #\'
                               + cast (movimientos_bancarios.numero_folio AS VARCHAR (10))
                               + \' \'
                               + tipos_movimientos.descripcion
                               + \' cuenta: \'
                               + cuentas.numero
                               + \' (\'+movimientos_bancarios.observaciones+\')\'
                              
                                  AS concepto,
                               movimientos_bancarios.importe + movimientos_bancarios.impuesto AS total,
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS timestamp_registro,
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               1 AS registro,
                               transacciones.comentario AS usuario_registro,
                               (-1) AS estatus,
                             movimientos_bancarios.id_movimiento_bancario ,
                             0 as cuadre
                          FROM ((((Tesoreria.movimientos_bancarios movimientos_bancarios
                                   INNER JOIN
                                   Tesoreria.tipos_movimientos tipos_movimientos
                                      ON (movimientos_bancarios.id_tipo_movimiento =
                                             tipos_movimientos.id_tipo_movimiento))
                                  INNER JOIN
                                  Contabilidad.datos_contables_obra datos_contables_obra
                                     ON (movimientos_bancarios.id_obra = datos_contables_obra.id_obra))
                                 INNER JOIN
                                 Tesoreria.movimiento_transacciones movimiento_transacciones
                                    ON (movimiento_transacciones.id_movimiento_bancario =
                                           movimientos_bancarios.id_movimiento_bancario))
                                INNER JOIN dbo.transacciones transacciones
                                   ON (movimiento_transacciones.id_transaccion =
                                          transacciones.id_transaccion))
                               INNER JOIN dbo.cuentas cuentas
                                  ON (cuentas.id_cuenta = movimientos_bancarios.id_cuenta)
                         WHERE     (movimientos_bancarios.id_movimiento_bancario = @id_movimiento)
                               AND (movimientos_bancarios.deleted_at IS NULL)
                        
                          SET @Id = SCOPE_IDENTITY();
                          SELECT  @err = @@ERROR,  @cuentaTran = @@ROWCOUNT;
                        
                          IF (@Id is null)BEGIN SET @ERROR = 1  GOTO TratarError END
                        
                          PRINT \'rowcount\'+CAST( @cuentaTran AS VARCHAR(10) )+ \'Id: \' + CAST( @Id AS VARCHAR(10) )+\' error:\' +CAST( @err AS VARCHAR(10) ) ; 
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
                        
                          PRINT \'Pólizas de movimientos bancarios registradas: \' + CAST( @cuentaTran AS VARCHAR(10) );
                        
                        
                        
                        --GENERACIÓN DE PARTIDAS DE PÓLIZA
                        
                        INSERT INTO [Contabilidad].[int_polizas_movimientos]
                                   ([id_int_poliza]
                                   ,[id_tipo_cuenta_contable]
                                   ,[cuenta_contable]
                                   ,[importe]
                                   ,[id_tipo_movimiento_poliza]
                                   ,[referencia]
                                   ,[concepto]--falta
                                   ,[id_empresa_cadeco]
                                   ,[razon_social]
                                   ,[rfc]
                                   ,[timestamp]
                               ,[created_at]
                               , id_transaccion_sao
                               , id_item_sao
                               ,usuario_registro
                                   )
                        SELECT 
                        @Id,
                         cuentas_contables_bancarias.id_tipo_cuenta_contable,
                               cuentas_contables_bancarias.cuenta as cuenta_contable,
                               
                             CASE
                                  WHEN     tipos_movimientos.id_tipo_movimiento = 4
                                       AND cuentas_contables_bancarias.id_tipo_cuenta_contable != 15
                                  THEN
                                     movimientos_bancarios.importe
                                  ELSE
                                     movimientos_bancarios.importe + movimientos_bancarios.impuesto
                               END
                                  AS importe,
                             
                               CASE cuentas_contables_bancarias.id_tipo_cuenta_contable
                                  WHEN 15 THEN [tipos_movimientos].naturaleza
                                  ELSE [int_tipos_cuentas_contables].id_naturaleza_poliza
                               END
                                  AS id_tipo_movimiento_poliza,
                                transacciones.referencia,
                                 (  (  (  (  (  (  (  \'*MOV. BAN. #\'
                                                    + cast (
                                                         movimientos_bancarios.numero_folio AS VARCHAR (10)))
                                                 + \' \')
                                              + tipos_movimientos.descripcion)
                                           + \' cuenta: \')
                                        + cuentas.numero)
                                     + \' (\')
                                  + movimientos_bancarios.observaciones)
                               + \')\'
                                  AS concepto,
                             
                               empresas.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              
                               transacciones.id_transaccion,
                               NULL AS id_item_sao,
                               transacciones.comentario AS usuario_registro
                          FROM ((((((((ContabilidadTesoreria.tipo_cuenta_por_movimiento tipo_cuenta_por_movimiento
                                       INNER JOIN
                                       Tesoreria.tipos_movimientos tipos_movimientos
                                          ON (tipo_cuenta_por_movimiento.id_tipo_movimiento =
                                                 tipos_movimientos.id_tipo_movimiento))
                                      INNER JOIN
                                      Tesoreria.movimientos_bancarios movimientos_bancarios
                                         ON (movimientos_bancarios.id_tipo_movimiento =
                                                tipos_movimientos.id_tipo_movimiento))
                                     INNER JOIN
                                     Contabilidad.datos_contables_obra datos_contables_obra
                                        ON (movimientos_bancarios.id_obra =
                                               datos_contables_obra.id_obra))
                                    INNER JOIN
                                    Tesoreria.movimiento_transacciones movimiento_transacciones
                                       ON (movimiento_transacciones.id_movimiento_bancario =
                                              movimientos_bancarios.id_movimiento_bancario))
                                   INNER JOIN dbo.transacciones transacciones
                                      ON (movimiento_transacciones.id_transaccion =
                                             transacciones.id_transaccion))
                                  INNER JOIN dbo.cuentas cuentas
                                     ON (cuentas.id_cuenta = movimientos_bancarios.id_cuenta))
                                 INNER JOIN
                                 Contabilidad.cuentas_contables_bancarias cuentas_contables_bancarias
                                    ON     (cuentas_contables_bancarias.id_cuenta = cuentas.id_cuenta)
                                       AND (tipo_cuenta_por_movimiento.id_tipo_cuenta_contable =
                                               cuentas_contables_bancarias.id_tipo_cuenta_contable))
                                INNER JOIN
                                Contabilidad.int_tipos_cuentas_contables int_tipos_cuentas_contables
                                   ON     (cuentas_contables_bancarias.id_tipo_cuenta_contable =
                                              int_tipos_cuentas_contables.id_tipo_cuenta_contable)
                                      AND (tipo_cuenta_por_movimiento.id_tipo_cuenta_contable =
                                              int_tipos_cuentas_contables.id_tipo_cuenta_contable))
                               INNER JOIN dbo.empresas empresas
                                  ON (cuentas.id_empresa = empresas.id_empresa)
                         WHERE     (movimientos_bancarios.id_movimiento_bancario = @id_movimiento)
                               AND (movimientos_bancarios.deleted_at IS NULL)
                               AND (cuentas_contables_bancarias.estatus = 1)
                               AND (cuentas_contables_bancarias.deleted_at IS NULL)
                             
                             UNION
                        
                             SELECT 
                        @Id,
                         24 AS id_tipo_cuenta_contable ,
                               int_cuentas_contables.cuenta_contable as cuenta_contable,
                               
                             movimientos_bancarios.impuesto
                               
                                  AS importe,
                             
                               1
                                  AS id_tipo_movimiento_poliza,
                                transacciones.referencia,
                                 (  (  (  (  (  (  (  \'*MOV. BAN. #\'
                                                    + cast (
                                                         movimientos_bancarios.numero_folio AS VARCHAR (10)))
                                                 + \' \')
                                              + tipos_movimientos.descripcion)
                                           + \' cuenta: \')
                                        + cuentas.numero)
                                     + \' (\')
                                  + movimientos_bancarios.observaciones)
                               + \')\'
                                  AS concepto,
                             
                               empresas.id_empresa,
                               empresas.razon_social,
                               empresas.rfc,
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS [timestamp],
                                 CONVERT (VARCHAR (10), GETDATE (), 121)
                               + \' \'
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                              
                               transacciones.id_transaccion,
                               NULL AS id_item_sao,
                               transacciones.comentario AS usuario_registro
                          FROM (((((
                                      
                                      Tesoreria.movimientos_bancarios movimientos_bancarios
                                       INNER JOIN
                                       Tesoreria.tipos_movimientos tipos_movimientos
                                          ON (movimientos_bancarios.id_tipo_movimiento =
                                                 tipos_movimientos.id_tipo_movimiento)   
                                    
                                    INNER JOIN
                                    Tesoreria.movimiento_transacciones movimiento_transacciones
                                       ON (movimiento_transacciones.id_movimiento_bancario =
                                              movimientos_bancarios.id_movimiento_bancario))
                                   INNER JOIN dbo.transacciones transacciones
                                      ON (movimiento_transacciones.id_transaccion =
                                             transacciones.id_transaccion))
                                  INNER JOIN dbo.cuentas cuentas
                                     ON (cuentas.id_cuenta = movimientos_bancarios.id_cuenta))
                                 )
                                
                               INNER JOIN dbo.empresas empresas
                                  ON (cuentas.id_empresa = empresas.id_empresa))
                                  inner join Contabilidad.int_cuentas_contables as int_cuentas_contables on (id_int_tipo_cuenta_contable = 24)
                         WHERE     (movimientos_bancarios.id_movimiento_bancario = @id_movimiento)
                               AND (movimientos_bancarios.deleted_at IS NULL)
                             and movimientos_bancarios.id_tipo_movimiento = 4
                             
                             ;
                              
                        
                        
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
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaMovimientosBancarios]');
    }
}
