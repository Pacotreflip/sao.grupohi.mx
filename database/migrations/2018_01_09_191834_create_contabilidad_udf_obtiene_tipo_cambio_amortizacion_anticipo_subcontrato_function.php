<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfObtieneTipoCambioAmortizacionAnticipoSubcontratoFunction extends Migration
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
                        -- Create date: 24/07/2017
                        -- Description: Función para obtener el TC que corresponde
                        -- a la factura del subcontrato de la estimación dada
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfObtieneTipoCambioAmortizacionAnticipoSubcontrato]
                        (
                          @id_estimacion INT
                        )
                        RETURNS FLOAT
                        AS
                        BEGIN
                          DECLARE @tipo_cambio float;
                        
                        
                        
                         SELECT  @tipo_cambio =isnull (factura.tipo_cambio, 0)
                          FROM ((dbo.items items_facturas
                                 LEFT OUTER JOIN dbo.transacciones factura
                                    ON (items_facturas.id_transaccion = factura.id_transaccion))
                                RIGHT OUTER JOIN
                                dbo.transacciones subcontrato
                                   ON (subcontrato.id_transaccion = items_facturas.id_antecedente))
                               RIGHT OUTER JOIN
                               dbo.transacciones estimacion
                                  ON (estimacion.id_antecedente = subcontrato.id_transaccion)
                         WHERE (estimacion.id_transaccion = @id_estimacion)  AND (factura.id_transaccion = 65);
                        
                         return @tipo_cambio;
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneTipoCambioAmortizacionAnticipoSubcontrato]');
    }
}
