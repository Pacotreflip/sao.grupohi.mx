<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadGeneraPolizaFacturaProcedure extends Migration
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
                        -- Description: 
                        -- =============================================
                        CREATE PROCEDURE [Contabilidad].[generaPolizaFactura]
                        @id_transaccion INT
                        AS
                        BEGIN
                          -- SET NOCOUNT ON added to prevent extra result sets from
                          -- interfering with SELECT statements.
                          SET NOCOUNT ON;
                        
                          BEGIN TRANSACTION;
                        
                          DECLARE @id_poliza int
                          DECLARE @monto_factura FLOAT
                          DECLARE @moneda_factura INT
                          DECLARE @manejo_almacenes BIT
                          DECLARE @costo_en_tipo_gasto BIT
                          DECLARE @tipo_cambio_factura REAL
                          DECLARE @ERROR int
                          DECLARE @cuadre FLOAT
                          DECLARE @cuentas_faltantes INT
                        
                          --INICIAR VARIABLES
                          SELECT 
                            @monto_factura = monto, 
                            @moneda_factura = id_moneda,
                            @tipo_cambio_factura = tipo_cambio
                          FROM transacciones
                          WHERE id_transaccion = @id_transaccion;
                        
                          SELECT 
                            @costo_en_tipo_gasto = costo_en_tipo_gasto, 
                            @manejo_almacenes = manejo_almacenes
                          FROM Contabilidad.datos_contables_obra dco
                          JOIN transacciones tra ON(dco.id_obra = tra.id_obra)
                          WHERE id_transaccion = @id_transaccion;
                        
                        --GENERAR ENCABEZADO DE PÓLIZA
                          EXEC  @id_poliza = [Contabilidad].[generaEncabezadoPolizaFactura]
                            @id_transaccion
                          /*Si la póliza no se generó se busca terminar la transacción*/
                            IF(not(@id_poliza >0))
                          BEGIN
                            SET @ERROR = 1  
                            GOTO TratarError
                          END
                        
                        --REGISTRO DE MOVIMIENTOS DE CANCELACIÓN DE ENTRADAS
                          EXEC   [Contabilidad].generaMovimientosCancelacionEntradas
                            @id_poliza
                        
                        --RECALCULO DE IMPORTES DE INVENTARIOS Y MOVIMIENTOS
                          EXEC   Contabilidad.actualizaValorInventariosyMovimientos
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS DE COMPLEMENTO FACTURA
                        
                          EXEC   [Contabilidad].[generaMovimientosComplementoFactura]
                            @id_poliza
                          
                        --REGISTRO DE MOVIMIENTOS A PROVEEDOR
                        
                          EXEC   [Contabilidad].[generaMovimientosProveedor]
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS A COSTOS DESDE ITEMS (ENTRADAS ALMACÉN / ¿MAQUINARIA?)
                        
                          EXEC   [Contabilidad].[generaMovimientosCostosDesdeItems]
                            @id_poliza
                        --REGISTRO DE MOVIMIENTOS A ALMACENES DESDE ITEMS (ENTRADAS ALMACÉN / ¿MAQUINARIA?)
                        
                          EXEC   [Contabilidad].generaMovimientosAlmacenesDesdeItems
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS A COSTOS DESDE TRANSACCIONES (RAYAS)
                        
                          EXEC   [Contabilidad].generaMovimientosCostosListasDeRaya
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS A COSTOS DESDE TRANSACCIONES (ESTIMACIONES)
                          EXEC   [Contabilidad].generaMovimientosCostosEstimacion
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS DE ANTICIPO (TAMBIEN SE INCLUYE AMORTIZACIÓN) (SUBCONTRATOS / ORDEN COMPRA MATERIAL / ORDEN RENTA MAQUINARIA)
                          EXEC   [Contabilidad].generaMovimientosAnticipo
                            @id_poliza
                        
                        --REGISTRO DE UTILIDAD / PERDIDA CAMBIARIA POR ANTICIPOS
                        
                          EXEC [Contabilidad].[generaMovimientosUtilidadPerdidaCambiariaAnticipo] 
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS DESCUENTOS/RECARGOS
                          EXEC   [Contabilidad].generaMovimientosDescuentosRecargos
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS FACTURA DE VARIOS
                          EXEC   [Contabilidad].generaMovimientosCostoFacturaDeVarios
                            @id_poliza
                        
                        --REGISTRA MOVIMIENTOS FONDO GARANTÍA DE SUBCONTRATOS
                        
                          EXEC [Contabilidad].generaMovimientosFondoGarantia
                            @id_poliza
                        
                        --REGISTRA MOVIMIENTOS RETENCIONES DE SUBCONTRATOS
                        
                          EXEC [Contabilidad].generaMovimientosRetencionesSubcontratos
                            @id_poliza
                        
                        --REGISTRA MOVIMIENTOS DEVOLUCIÓN DE RETENCIONES DE SUBCONTRATOS
                        
                          EXEC [Contabilidad].generaMovimientosDevolucionRetencionesSubcontratos
                            @id_poliza
                        
                        --REGISTRO DE MOVIMIENTOS A COSTOS DESDE TIPO DE GASTO
                        
                        --REGISTRO DE MOVIMIENTOS A COSTOS DESDE FAMILIA DE MATERIAL
                        
                        
                        
                        --DATOS DE PÓLIZA TOTAL, CUADRE Y ESTADO
                        
                        SET @cuadre =  Contabilidad.cuadrar_poliza(@id_poliza) ;
                          PRINT \'Cuadre póliza ajuste: \' +CAST( @cuadre AS VARCHAR(10) );
                          update Contabilidad.int_polizas set Cuadre = @cuadre where id_int_poliza = @id_poliza;
                        
                          select @cuentas_faltantes = count(*) from Contabilidad.int_polizas_movimientos where id_int_poliza = @id_poliza and cuenta_contable is null ;
                        
                          if @cuentas_faltantes > 0 OR abs(@cuadre) > 0.99
                          begin
                            update Contabilidad.int_polizas set estatus = -1 where id_int_poliza = @id_poliza;
                          end
                          else
                          begin
                            update Contabilidad.int_polizas set estatus = 0 where id_int_poliza = @id_poliza;
                          end
                        
                            /*Actualizar importe de póliza */
                        
                          update Contabilidad.int_polizas set total = (
                          SELECT  (total.importe) AS importe
                          FROM (select sum(importe) as importe from int_polizas_movimientos where id_int_poliza = @id_poliza and id_tipo_movimiento_poliza = 1) as total)
                          WHERE id_int_poliza = @id_poliza;
                        
                        
                          TratarError:
                          IF @ERROR=1 
                          BEGIN 
                            PRINT \'Póliza no registrada\';
                                ROLLBACK TRANSACTION;
                                RETURN(-1);
                          END
                        
                          COMMIT;
                            
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP PROCEDURE [Contabilidad].[generaPolizaFactura]');
    }
}
