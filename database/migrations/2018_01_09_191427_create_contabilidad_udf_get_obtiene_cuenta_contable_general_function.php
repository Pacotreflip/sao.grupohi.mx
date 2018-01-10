<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfGetObtieneCuentaContableGeneralFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('CREATE FUNCTION [Contabilidad].[udfObtieneCuentaContableGeneral](@obra INT, @tipo_cuenta_contable INT )
                        RETURNS VARCHAR(50)
                        AS
                        --=======================================
                        -- Fecha de Creacion: 07/07/2017 =
                        -- Programador: Elizabeth Martinez Solano =
                        -- ======================================
                        
                        --======================================================
                        -- Objetivo: Obtener la cuenta contable de la tabla cuentas generales =
                        --======================================================
                          BEGIN
                            DECLARE
                            @CuentaContable VARCHAR(50)
                            
                          SELECT @CuentaContable = cuenta_contable
                          FROM Contabilidad.int_cuentas_contables
                          WHERE id_obra = @obra
                          AND id_int_tipo_cuenta_contable = @tipo_cuenta_contable
                          AND deleted_at IS NULL;
                        
                          RETURN @CuentaContable
                          END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfObtieneCuentaContableGeneral]');
    }
}
