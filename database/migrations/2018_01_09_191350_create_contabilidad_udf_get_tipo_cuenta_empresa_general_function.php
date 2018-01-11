<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadUdfGetTipoCuentaEmpresaGeneralFunction extends Migration
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
                        -- Description: Función para obtener el tipo de cuenta contable 
                        -- que le corresponde a un movimiento
                        -- =============================================
                        CREATE FUNCTION [Contabilidad].[udfGetTipoCuentaEmpresaGeneral]
                        (
                          @id_transaccion int,
                          @fondo_garantia int,
                          @moneda int,
                          @complementaria int,
                          @de_anticipo int
                        )
                        RETURNS INT
                        AS
                        BEGIN
                          DECLARE @IdTipoCuentaEmpresa INT,
                           @tipo_transaccion INT,
                           @opciones INT,
                           @numero_item INT;
                        
                            SELECT TOP(1) @numero_item = numero
                           FROM items
                           WHERE id_transaccion = @id_transaccion
                           AND numero = 7;
                        
                          SELECT TOP(1) @tipo_transaccion = tipo_transaccion,
                          @opciones = opciones FROM(
                          SELECT 
                          isnull(transacciones_1.tipo_transaccion, transacciones_antecedentes.tipo_transaccion) as tipo_transaccion,
                          isnull(transacciones_1.opciones, transacciones_antecedentes.opciones) as opciones,
                               transacciones.id_transaccion,
                             items.item_antecedente,
                               SUM (items.importe) AS importe,
                             items.id_antecedente
                          FROM (dbo.items items
                                LEFT JOIN
                                dbo.transacciones transacciones_1
                                   ON (items.id_antecedente = transacciones_1.id_transaccion)
                               
                                LEFT JOIN
                                dbo.items items_antecedentes
                                   ON (items.item_antecedente = items_antecedentes.id_item)
                        
                                 LEFT JOIN
                                dbo.transacciones transacciones_antecedentes
                                   ON (transacciones_antecedentes.id_transaccion = items_antecedentes.id_transaccion)
                        
                               )
                               LEFT JOIN
                               dbo.transacciones transacciones
                                  ON (transacciones.id_transaccion = items.id_transaccion)
                         WHERE (transacciones.id_transaccion = @id_transaccion)
                        GROUP BY transacciones_1.tipo_transaccion,
                                 transacciones_1.opciones,
                                 transacciones.id_transaccion,
                             items.item_antecedente,
                              items.id_antecedente,
                              transacciones_antecedentes.tipo_transaccion,
                              transacciones_antecedentes.opciones
                            
                             )
                             AS tabla
                        ORDER BY importe DESC;
                        
                        
                          IF @fondo_garantia > 0 --CUENTA FONDO GARANTÍA
                          BEGIN 
                            SET @IdTipoCuentaEmpresa = 10;
                          END
                        
                          IF (@tipo_transaccion IN(19,33,99,102,51,52) OR @numero_item = 7) AND @complementaria = 0 AND @moneda = 1 AND @de_anticipo = 0 AND @fondo_garantia = 0  -- (CUENTA PROVEEDOR)
                          BEGIN
                            SET @IdTipoCuentaEmpresa = 2;
                          END
                        
                          IF @tipo_transaccion IN(19,33,99,102,51,52) AND @complementaria = 0 AND @moneda != 1 AND @de_anticipo = 0 AND @fondo_garantia = 0--(CUENTA PROVEEDOR DOLARES)
                          BEGIN
                            SET @IdTipoCuentaEmpresa = 27;
                          END
                        
                          IF @tipo_transaccion IN(19,33,99,102,51,52) AND @complementaria = 1 AND @moneda != 1 AND @de_anticipo = 0 AND @fondo_garantia = 0--(CUENTA PROVEEDOR COMPLEMENTARIA)
                          BEGIN
                            SET @IdTipoCuentaEmpresa = 28;
                          END
                        
                          IF @tipo_transaccion IN(19,33,99,102,51,52)  AND @complementaria = 0  AND @moneda = 1 AND @de_anticipo = 1 AND @fondo_garantia = 0  --(CUENTA ANTICIPO PROVEEDOR)
                          BEGIN 
                            SET @IdTipoCuentaEmpresa = 12;
                          END
                          
                          IF @tipo_transaccion IN(19,33,99,102,51,52) AND @complementaria = 0 AND @moneda != 1 AND @de_anticipo = 1 AND @fondo_garantia = 0--(ANTICIPO DOLARES)
                          BEGIN
                            SET @IdTipoCuentaEmpresa = 31;
                          END
                        
                          IF @tipo_transaccion IN(19,33,99,102,51,52) AND @complementaria = 1 AND @moneda != 1 AND @de_anticipo = 1 AND @fondo_garantia = 0--(CUENTA ANTICIPO USD COMPLEMENTARIA)
                          BEGIN
                            SET @IdTipoCuentaEmpresa = 32;
                          END
                          
                          
                          --IF @tipo_transaccion in(51,52)  AND @de_anticipo = 1 --Anticipo subcontrato (CUENTA ANTICIPO SUBCONTRATISTA)
                          --BEGIN
                          --  SET @IdTipoCuentaEmpresa = 11;
                          --END
                          
                          --IF @tipo_transaccion IN(51,52)  AND @complementaria = 0 AND @dolares = 0 AND @de_anticipo = 0 --Estimación (CUENTA SUBCONTRATISTA)
                          --BEGIN
                          --  SET @IdTipoCuentaEmpresa = 30;
                          --END
                        
                          RETURN @IdTipoCuentaEmpresa
                        
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION [Contabilidad].[udfGetTipoCuentaEmpresaGeneral]');
    }
}
