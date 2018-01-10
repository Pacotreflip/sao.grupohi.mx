<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfObtieneIvaPagadoFunction extends Migration
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
                        -- Create date: 27/07/2017
                        -- Description: Función para obtener el IVA pagado
                        -- considerando que un pago puede pagar parcialmente N
                        --facturas y que el iva en las facturas no siempre es 
                        -- 16%, incluso puede venir en 0
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfObtieneIVAPagado]
                        (
                          @id_transaccion INT
                        )
                        RETURNS FLOAT
                        AS
                        BEGIN
                          DECLARE @iva_pagado float;
                         SELECT 
                              @iva_pagado = sum (
                                    (orden_pago.monto * -1)
                                  * CASE
                                       WHEN complemento_factura.iva IS NULL THEN facturas.impuesto
                                       ELSE complemento_factura.iva
                                    END
                                  / facturas.monto)
                                  
                          FROM (((dbo.transacciones orden_pago
                                  INNER JOIN
                                  dbo.transacciones contrarecibo
                                     ON (orden_pago.id_antecedente = contrarecibo.id_transaccion))
                                 INNER JOIN dbo.transacciones pago
                                    ON (pago.numero_folio = orden_pago.numero_folio))
                                INNER JOIN dbo.transacciones facturas
                                   ON (orden_pago.id_referente = facturas.id_transaccion))
                               LEFT OUTER JOIN
                               Finanzas.complemento_factura complemento_factura
                                  ON (facturas.id_transaccion = complemento_factura.id_transaccion)
                         WHERE (pago.tipo_transaccion = 82) AND (orden_pago.tipo_transaccion = 68) AND
                         pago.id_transaccion = @id_transaccion 
                        GROUP BY pago.id_transaccion,
                                 pago.tipo_transaccion,
                                 orden_pago.tipo_transaccion
                        
                        
                         return @iva_pagado;
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneIVAPagado]');
    }
}
