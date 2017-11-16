<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContabilidadTesoreriaTipoCuentaPorMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ContabilidadTesoreria.tipo_cuenta_por_movimiento', function (Blueprint $table) {
            $table->unsignedInteger("id_tipo_movimiento")->nullable();
            $table->unsignedInteger("id_tipo_cuenta_contable")->nullable();
            
            $table->foreign('id_tipo_movimiento')
                ->references('id_tipo_movimiento')
                ->on('Tesoreria.tipos_movimientos');
            
            $table->foreign('id_tipo_cuenta_contable')
                ->references('id_tipo_cuenta_contable')
                ->on('Contabilidad.int_tipos_cuentas_contables');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ContabilidadTesoreria.tipo_cuenta_por_movimiento');
    }
}
