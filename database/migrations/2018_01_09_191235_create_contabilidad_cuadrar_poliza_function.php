<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCuadrarPolizaFunction extends Migration
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
                        -- Create date: 29/06/2017
                        -- Description: Función para llenar el valor del cuadre de las pólizas
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[cuadrar_poliza]
                        (
                        @id_poliza as INT
                        )
                        RETURNS FLOAT
                        AS
                        BEGIN
                          DECLARE @cuadre FLOAT
                          SET @cuadre = (SELECT  CONVERT(DECIMAL(10,2),isnull(sum(importe),0)) from Contabilidad.int_polizas_movimientos where id_int_poliza = @id_poliza AND id_tipo_movimiento_poliza = 1)-
                          (SELECT  CONVERT(DECIMAL(10,2),isnull(sum(importe),0))  from  Contabilidad.int_polizas_movimientos where id_int_poliza = @id_poliza  AND id_tipo_movimiento_poliza = 2);
                          RETURN @cuadre
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[cuadrar_poliza]');
    }
}
