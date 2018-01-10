<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfObtieneTipoCambioAmortizacionAnticipoFunction extends Migration
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
                        -- a la orden de compra 
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfObtieneTipoCambioAmortizacionAnticipo]
                        (
                          @id_item_entrada INT
                        )
                        RETURNS FLOAT
                        AS
                        BEGIN
                          DECLARE @tipo_cambio float;
                          SELECT @tipo_cambio =  transacciones_2.tipo_cambio
                          FROM ((((dbo.items items_1
                                   INNER JOIN dbo.items items_2
                                      ON (items_1.id_item = items_2.item_antecedente))
                                  INNER JOIN dbo.items items
                                     ON (items.item_antecedente = items_1.id_item))
                                 INNER JOIN
                                 dbo.transacciones transacciones_1
                                    ON (transacciones_1.id_transaccion = items.id_transaccion))
                                INNER JOIN dbo.transacciones transacciones
                                   ON (items_1.id_transaccion = transacciones.id_transaccion))
                               INNER JOIN
                               dbo.transacciones transacciones_2
                                  ON (transacciones_2.id_transaccion = items_2.id_transaccion)
                         WHERE (items.id_item = @id_item_entrada) AND (transacciones_2.tipo_transaccion = 65);
                        
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
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneTipoCambioAmortizacionAnticipo]');
    }
}
