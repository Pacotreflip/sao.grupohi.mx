<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraEncabezadoPolizaFacturaProcedure extends Migration
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
                        -- Description: Procedimiento para procesar los registros
                        -- de facturas revisadas 
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaEncabezadoPolizaFactura]
                          -- Add the parameters for the stored procedure here
                          @id_transaccion INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                        
                          DECLARE
                          @cuentaTran INT,
                          @Id INT,
                          @err INT,
                          @ERROR INT,
                          @cuadre FLOAT,
                          @cuentas_faltantes INT
                        
                          --GENERACIÓN DE PÓLIZA
                        
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
                               393 AS id_tipo_poliza_interfaz,
                               3 AS id_tipo_poliza_contpaq,
                               DB_NAME () AS alias_bd_cadeco,
                               transacciones.id_obra AS id_obra_cadeco,
                               transacciones.id_transaccion AS id_transaccion_sao,
                               datos_contables_obra.NumobraContPaq AS id_obra_contpaq,
                               datos_contables_obra.BDContPaq AS alias_bd_contpaq,
                               cr.fecha,
                        
                             LEFT(\'*RF *\' +transacciones.referencia+\'* CR#\'+ cast(cr.numero_folio as varchar(10))+\' \'+empresas.razon_social+\' (\' + isnull(transacciones.observaciones,\'\')+\') \',3900) AS concepto,
                               case  when SUM(inventarios.monto_total) IS NOT null then SUM (inventarios.monto_total)*1.16 else SUM (movimientos.monto_total)*1.16 end importe,
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             CONVERT(VARCHAR(10), GETDATE(), 121) +\' \'+ CONVERT(VARCHAR(8), GETDATE(), 108) AS [timestamp],
                             1 as registro,
                             0 as cuadre,
                             transacciones.comentario as usuario_registro,
                             -2 as estatus
                          FROM (dbo.transacciones transacciones
                              LEFT OUTER JOIN dbo.items items
                                 ON (transacciones.id_transaccion = items.id_transaccion)
                        
                        
                              LEFT OUTER JOIN dbo.transacciones cr
                                 ON (transacciones.id_antecedente = cr.id_transaccion)
                        
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
                        
                               AND
                               transacciones.id_transaccion not in(select id_transaccion_sao from Contabilidad.int_polizas WHERE id_transaccion_sao is not null )
                           GROUP BY transacciones.id_obra,
                                 transacciones.id_transaccion,
                                 datos_contables_obra.NumobraContPaq,
                                 datos_contables_obra.BDContPaq,
                                 cr.fecha,
                                 transacciones.observaciones,
                             transacciones.referencia,
                                 transacciones.tipo_transaccion,
                             transacciones.numero_folio,
                             transacciones.comentario,
                             cr.numero_folio,
                             empresas.razon_social; 
                        
                          SET @Id = SCOPE_IDENTITY();
                          SELECT  @err = @@ERROR,
                          @cuentaTran = @@ROWCOUNT;
                        
                          IF (@Id is null)BEGIN SET @ERROR = 1  GOTO TratarError END
                        
                          PRINT \'rowcount\'+CAST( @cuentaTran AS VARCHAR(10) )+ \'Id: \' + CAST( @Id AS VARCHAR(10) )+\' error:\' +CAST( @err AS VARCHAR(10) ) ; 
                        
                        
                          PRINT \'Pólizas de factura registradas: \' +  CAST( @cuentaTran AS VARCHAR(10) );
                        
                          TratarError:
                          IF @ERROR=1 
                          BEGIN 
                            PRINT \'Transacción no disponible para registro\';
                                
                                RETURN(-1);
                            
                          END
                        
                          RETURN @Id;
                          
                        
                        END
                        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaEncabezadoPolizaFactura]');
    }
}
