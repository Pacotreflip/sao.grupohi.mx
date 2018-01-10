<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaCancelacionProcedure extends Migration
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
                        -- Create date: 02/08/2017
                        -- Description: Procedimiento almancenado para generar una póliza 
                        -- de cancelación a partir de una transacción cancelada dada
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaCancelacion] 
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
                          @id_poliza INT,
                          @tipo_poliza INT,
                          @tipo_poliza_nuevo INT,
                          @tipo_poliza_contpaq INT,
                          @id_transaccion_cancelada INT,
                          @fecha DATETIME
                        
                          SELECT @id_poliza = id_int_poliza FROM Contabilidad.int_polizas WHERE id_transaccion_sao = @id_transaccion;
                          SELECT @tipo_poliza = id_tipo_poliza_interfaz FROM Contabilidad.int_polizas WHERE id_int_poliza = @id_poliza;
                          SELECT @tipo_poliza_contpaq = id_tipo_poliza_contpaq FROM Contabilidad.int_polizas WHERE id_int_poliza = @id_poliza;
                          SELECT @fecha = created_at FROM Contabilidad.transacciones_canceladas WHERE id_transaccion = @id_transaccion;
                          SELECT @id_transaccion_cancelada = id FROM Contabilidad.transacciones_canceladas WHERE id_transaccion = @id_transaccion;
                        
                          --DEFINIR EL TIPO DE PÓLIZA DE CANCELACIÓN DE ACUERDO AL TIPO DE PÓLIZA DE LA TRANSACCIÓN ORIGINAL
                          IF @tipo_poliza = 389 --DE ENTRADA DE ALMACÉN
                          BEGIN 
                            SET @tipo_poliza_nuevo = 395;
                          END
                        
                          IF @tipo_poliza = 390  --DE SALIDA DE ALMACÉN
                          BEGIN 
                            SET @tipo_poliza_nuevo = 396;
                          END
                        
                          IF @tipo_poliza = 391  --DE TRANSFERENCIA DE ALMACÉN
                          BEGIN 
                            SET @tipo_poliza_nuevo = 397;
                          END
                        
                          IF @tipo_poliza = 393  --DE FACTURA
                          BEGIN 
                            SET @tipo_poliza_nuevo = 398;
                          END
                        
                          IF @tipo_poliza = 394  --DE PAGO
                          BEGIN 
                            SET @tipo_poliza_nuevo = 399;
                          END
                        
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
                            estatus,
                            id_transaccion_cancelada
                          )
                          SELECT 2 AS id_tipo_poliza,
                               @tipo_poliza_nuevo AS id_tipo_poliza_interfaz,
                               @tipo_poliza_contpaq AS id_tipo_poliza_contpaq,
                               alias_bd_cadeco,
                              id_obra_cadeco,
                            id_transaccion_sao,
                            id_obra_contpaq,
                            alias_bd_contpaq,
                            @fecha,
                            LEFT(\'CANC. \' + concepto, 100),
                            total *-1,
                            timestamp_registro,
                            CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108),
                            registro,
                            cuadre,
                            usuario_registro,
                            -1,
                            @id_transaccion_cancelada
                          FROM Contabilidad.int_polizas 
                          WHERE id_int_poliza = @id_poliza
                          AND id_transaccion_cancelada NOT IN(SELECT id_transaccion_cancelada FROM  Contabilidad.int_polizas where id_transaccion_cancelada = @id_transaccion_cancelada); 
                        
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
                        
                        PRINT \'Pólizas de cancelación registrada: \' + 
                          CAST( @cuentaTran AS VARCHAR(10) );
                        END
                        
                        
                        --GENERACIÓN DE PARTIDAS DE PÓLIZA CON IMPORTE NEGATIVO
                        
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
                        SELECT 
                              @Id
                              ,[id_tipo_cuenta_contable]
                                   ,[cuenta_contable]
                                   ,[importe]*-1
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
                         FROM Contabilidad.int_polizas_movimientos 
                          WHERE id_int_poliza = @id_poliza;        
                        
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
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaCancelacion]');
    }
}
