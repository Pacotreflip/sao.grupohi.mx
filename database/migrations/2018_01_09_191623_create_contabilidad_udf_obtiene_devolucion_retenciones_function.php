<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfObtieneDevolucionRetencionesFunction extends Migration
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
                        -- Create date: 01/08/2017
                        -- Description: Función para obtener el importe de las devoluciones
                        -- de retención de las estimaciones relacionadas con la factura en cuestión,
                        -- la información se toma del módulo WEB de Estimaciones puede venir en 0
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfObtieneDevolucionRetenciones]
                        (
                          @id_transaccion INT
                        )
                        RETURNS FLOAT
                        AS
                        BEGIN
                          DECLARE @retenciones float;
                        
                          /*
                          SELECT transacciones.id_transaccion,
                               SUM (Estimaciones.ImporteFondoGarantia) AS fondo_garantia,
                               SUM (transacciones.IVARetenido) AS ret_iva_10,
                               SUM (isnull (retencion.importe, 0)) AS retenciones_subcontratos,
                               empresas.razon_social,
                               SUM (retencion_liberacion.importe)
                                  AS devolucion_retenciones_subcontratos,
                               items.id_transaccion,
                               transacciones.numero_folio
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.empresas empresas
                                      ON (transacciones.id_empresa = empresas.id_empresa))
                                  LEFT OUTER JOIN
                                  SubcontratosEstimaciones.retencion retencion
                                     ON (transacciones.id_transaccion = retencion.id_transaccion))
                                 RIGHT OUTER JOIN
                                 SubcontratosEstimaciones.Estimaciones Estimaciones
                                    ON (Estimaciones.IDEstimacion = transacciones.id_transaccion))
                                LEFT OUTER JOIN
                                SubcontratosEstimaciones.retencion_liberacion retencion_liberacion
                                   ON (retencion_liberacion.id_transaccion =
                                          Estimaciones.IDEstimacion))
                               LEFT OUTER JOIN dbo.items items
                                  ON (items.id_antecedente = transacciones.id_transaccion)
                         WHERE (items.id_transaccion = 2474)
                        GROUP BY transacciones.id_transaccion,
                                 empresas.razon_social,
                                 items.id_transaccion,
                                 transacciones.numero_folio
                          */
                        
                         SELECT 
                              @retenciones = SUM (isnull (retencion_liberacion.importe, 0))
                                  
                          FROM ((((dbo.transacciones transacciones
                                   INNER JOIN dbo.empresas empresas
                                      ON (transacciones.id_empresa = empresas.id_empresa))
                                  LEFT OUTER JOIN
                                  SubcontratosEstimaciones.retencion retencion
                                     ON (transacciones.id_transaccion = retencion.id_transaccion))
                                 RIGHT OUTER JOIN
                                 SubcontratosEstimaciones.Estimaciones Estimaciones
                                    ON (Estimaciones.IDEstimacion = transacciones.id_transaccion))
                                LEFT OUTER JOIN
                                SubcontratosEstimaciones.retencion_liberacion retencion_liberacion
                                   ON (retencion_liberacion.id_transaccion =
                                          Estimaciones.IDEstimacion))
                               LEFT OUTER JOIN dbo.items items
                                  ON (items.id_antecedente = transacciones.id_transaccion)
                         WHERE (items.id_transaccion = @id_transaccion)
                        GROUP BY transacciones.id_transaccion,
                                 empresas.razon_social,
                                 items.id_transaccion,
                                 transacciones.numero_folio
                        
                        
                         return @retenciones;
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneDevolucionRetenciones]');
    }
}
