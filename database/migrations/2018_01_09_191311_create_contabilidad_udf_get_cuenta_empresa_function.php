<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfGetCuentaEmpresaFunction extends Migration
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
                        -- Description: Función para obtener la cuenta contable de una 
                        -- empresa indicando su tipo
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfGetCuentaEmpresa]
                        (
                          @id_obra int,
                          @id_empresa int,
                          @id_tipo_cuenta_general int,
                          @id_tipo_cuenta_empresa int
                        )
                        RETURNS VARCHAR(254)
                        AS 
                        BEGIN
                          /*
                          ID\'S DE CUENTAS GENERALES
                        
                          27 PROVEEDOR USD 2
                          28 PROVEEDOR COMPLEMENTARIA 3
                          2 PROVEEDOR PESOS 1
                          12 ANTICIPO A PROVEEDOR 4
                          10 RETENCIÓN DE FONDO DE GARANTÍA 8
                          30 SUBCONTRATISTA 5
                          11 ANTICIPO A SUBCONTRATISTA 9
                          31 SUBCONTRATISTA USD 6
                          32 SUBCONTRATISTA COMPL. 7
                          */
                          DECLARE @cuenta VARCHAR(254)
                          --@id_tipo_cuenta_empresa INT
                          ;
                          if(@id_tipo_cuenta_empresa = 0)
                          begin
                          
                            IF @id_tipo_cuenta_general = 2
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 1;
                            END
                            IF @id_tipo_cuenta_general = 27
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 2;
                            END
                            IF @id_tipo_cuenta_general = 28
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 3;
                            END
                            IF @id_tipo_cuenta_general = 12
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 4;
                            END
                            IF @id_tipo_cuenta_general = 10
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 8;
                            END
                            IF @id_tipo_cuenta_general = 30
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 5;
                            END
                            IF @id_tipo_cuenta_general = 11
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 9;
                            END
                            IF @id_tipo_cuenta_general = 31
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 6;
                            END
                            IF @id_tipo_cuenta_general = 32
                            BEGIN
                              SET @id_tipo_cuenta_empresa = 7;
                            END
                          END
                          
                          SELECT 
                              @cuenta = cuenta
                          FROM
                              Contabilidad.cuentas_empresas
                          WHERE
                            id_obra = @id_obra AND
                            id_empresa = @id_empresa AND
                            id_tipo_cuenta_empresa = @id_tipo_cuenta_empresa AND
                            estatus = 1
                          
                          RETURN @cuenta;
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfGetCuentaEmpresa]');
    }
}
