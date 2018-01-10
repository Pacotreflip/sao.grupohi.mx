<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaTraspasoCuentasProcedure extends Migration
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
                        -- Description: Procedimiento almancenado para generar una póliza a partir de la transaccion traspaso entre cuentas
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaTraspasoEntreCuentas] 
                          @id_traspaso INT
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
                            id_traspaso,
                            cuadre
                          )
                          SELECT 2 AS id_tipo_poliza,
                               401 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               traspaso_cuentas.id_obra AS id_obra_cadeco,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               traspaso_cuentas.fecha,
                                 \'*TRSP #\'
                               + cast (traspaso_cuentas.numero_folio AS VARCHAR (10))
                               + \'* DE \'
                               + empresas.razon_social
                               + \' (\'
                               + cuentas.numero
                               + \') \'
                               + \' A \'
                               + empresas_1.razon_social
                               + \' (\'
                               + cuentas_1.numero
                               + \') \'
                               + \' (\'
                               + isnull (traspaso_cuentas.observaciones, \'\')
                               + \')\'
                                  AS concepto,
                               traspaso_cuentas.importe AS total,
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS timestamp_registro,
                                 (CONVERT (VARCHAR (10), GETDATE (), 121) + \' \')
                               + CONVERT (VARCHAR (8), GETDATE (), 108)
                                  AS created_at,
                               1 AS registro,
                               transacciones.comentario AS usuario_registro,
                               (-1) AS estatus,
                             traspaso_cuentas.id_traspaso,
                             0
                          FROM ((((((Tesoreria.traspaso_transacciones traspaso_transacciones
                                     INNER JOIN
                                     Tesoreria.traspaso_cuentas traspaso_cuentas
                                        ON (traspaso_transacciones.id_traspaso =
                                               traspaso_cuentas.id_traspaso))
                                    INNER JOIN
                                    dbo.transacciones transacciones
                                       ON (traspaso_transacciones.id_transaccion =
                                              transacciones.id_transaccion))
                                   INNER JOIN
                                   Contabilidad.datos_contables_obra datos_contables_obra
                                      ON (traspaso_cuentas.id_obra = datos_contables_obra.id_obra))
                                  INNER JOIN dbo.cuentas cuentas
                                     ON (traspaso_cuentas.id_cuenta_origen = cuentas.id_cuenta))
                                 INNER JOIN dbo.empresas empresas
                                    ON (empresas.id_empresa = cuentas.id_empresa))
                                INNER JOIN dbo.cuentas cuentas_1
                                   ON (cuentas_1.id_cuenta = traspaso_cuentas.id_cuenta_destino))
                               INNER JOIN dbo.empresas empresas_1
                                  ON (empresas_1.id_empresa = cuentas_1.id_empresa)
                         WHERE traspaso_cuentas.id_traspaso = @id_traspaso
                         AND
                               traspaso_cuentas.id_traspaso not in(select id_traspaso from Contabilidad.int_polizas  where id_traspaso is not null )
                        GROUP BY traspaso_cuentas.id_traspaso,
                                 traspaso_cuentas.importe,
                                 transacciones.comentario,
                                 traspaso_cuentas.fecha,
                                 datos_contables_obra.BDContPaq,
                                 datos_contables_obra.NumobraContPaq,
                                 traspaso_cuentas.id_obra,
                                 traspaso_cuentas.numero_folio,
                                 traspaso_cuentas.observaciones,
                                 empresas.razon_social,
                                 empresas_1.razon_social,
                                 cuentas.numero,
                                 cuentas_1.numero;
                        
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
                        
                          PRINT \'Pólizas de transferencias bancarias registradas: \' + CAST( @cuentaTran AS VARCHAR(10) );
                        
                        
                        
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
                        15 AS id_tipo_cuenta_contable,
                               cuentas.cuenta_contable,
                               traspaso_cuentas.importe,
                               CASE transacciones.tipo_transaccion WHEN 83 THEN 1 WHEN 84 THEN 2 END
                                  AS id_tipo_movimiento_poliza,
                               transacciones.referencia,
                                 \'*TRSP #\'
                               + cast (traspaso_cuentas.numero_folio AS VARCHAR (10))
                               + \'* \'
                               + \' DE \'
                               + empresas_1.razon_social
                               + \' (\'
                               + cuentas_1.numero
                               + \') \'
                               + \' A \'
                               + empresas_2.razon_social
                               + \' (\'
                               + cuentas_2.numero
                               + \') \'
                               + \' (\'
                               + isnull (traspaso_cuentas.observaciones, \'\')
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
                          FROM (((((((Tesoreria.traspaso_transacciones traspaso_transacciones
                                      INNER JOIN
                                      Tesoreria.traspaso_cuentas traspaso_cuentas
                                         ON (traspaso_transacciones.id_traspaso =
                                                traspaso_cuentas.id_traspaso))
                                     INNER JOIN
                                     dbo.transacciones transacciones
                                        ON (traspaso_transacciones.id_transaccion =
                                               transacciones.id_transaccion))
                                    INNER JOIN dbo.cuentas cuentas
                                       ON (cuentas.id_cuenta = transacciones.id_cuenta))
                                   INNER JOIN dbo.empresas empresas
                                      ON (cuentas.id_empresa = empresas.id_empresa))
                                  INNER JOIN dbo.cuentas cuentas_1
                                     ON (cuentas_1.id_cuenta = traspaso_cuentas.id_cuenta_origen))
                                 INNER JOIN dbo.empresas empresas_1
                                    ON (cuentas_1.id_empresa = empresas_1.id_empresa))
                                INNER JOIN dbo.cuentas cuentas_2
                                   ON (cuentas_2.id_cuenta = traspaso_cuentas.id_cuenta_destino))
                               INNER JOIN dbo.empresas empresas_2
                                  ON (cuentas_2.id_empresa = empresas_2.id_empresa)
                         WHERE (traspaso_cuentas.id_traspaso = @id_traspaso);
                              
                        
                        
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
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaTraspasoEntreCuentas]');
    }
}
