<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContabilidadIntPolizasMovimientosCostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.int_polizas_movimientos_costos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("id_int_poliza_movimiento");
            $table->unsignedInteger("id_concepto")->nullable();
            $table->unsignedInteger("id_costo")->nullable();
            
            $table->foreign('id_int_poliza_movimiento')
                ->references('id_int_poliza_movimiento')
                ->on('Contabilidad.int_polizas_movimientos');
            
            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('conceptos');
            
            $table->foreign('id_costo')
                ->references('id_costo')
                ->on('costos');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.int_polizas_movimientos_costos');
    }
}
