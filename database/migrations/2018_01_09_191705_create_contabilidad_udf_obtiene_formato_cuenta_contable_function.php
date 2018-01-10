<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfObtieneFormatoCuentaContableFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('CREATE FUNCTION [Contabilidad].[udfObtieneFormatoCuentaContable]( @CuentaContable VARCHAR(200) )
                        RETURNS VARCHAR(200)
                        AS
                        --=====================================
                        -- Fecha de Creacion: 07/07/2017     =
                        -- Programador: Elizabeth Martinez Solano   =
                        -- ====================================
                        
                        --==================================================================
                        -- Objetivo: Cambiar el formato de las cuentas contables       =
                        -- al generar prepolizas por consistencia de la interfaz a CONTPAQ =
                        --==================================================================
                          BEGIN
                            DECLARE
                            @CuentaFormateada VARCHAR(200)
                            SET @CuentaFormateada = \'\'
                            
                            -- QUITA ESPACIOS EN BLANCO
                            SET @CuentaFormateada = REPLACE(@CuentaContable, \' \', \'\')
                            SET @CuentaFormateada = LTRIM(@CuentaFormateada)
                            SET @CuentaFormateada = RTRIM(@CuentaFormateada)
                            -- QUITA GUIONES
                            SET @CuentaFormateada = REPLACE( @CuentaFormateada, \'-\', \'\' )
                            
                            RETURN @CuentaFormateada    
                          END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneFormatoCuentaContable]');
    }
}
