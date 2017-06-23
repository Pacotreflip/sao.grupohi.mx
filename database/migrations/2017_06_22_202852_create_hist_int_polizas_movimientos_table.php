<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateHistIntPolizasMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.hist_int_polizas_movimientos', function (Blueprint $table) {
            $table->increments('id_hist_int_poliza_movimiento');
            $table->unsignedInteger('id_int_poliza_movimiento')->index();
            $table->unsignedInteger('id_int_poliza')->index()->nullable();
            $table->unsignedInteger('id_tipo_cuenta_contable')->index()->nullable();
            $table->unsignedInteger('id_cuenta_contable')->index()->nullable();
            $table->string('cuenta_contable',100)->nullable();
            $table->float('importe')->nullable();
            $table->unsignedInteger('id_tipo_movimiento_poliza')->index()->nullable();
            $table->string('referencia',10)->nullable();
            $table->string('concepto',100)->nullable();
            $table->integer('id_empresa_cadeco')->nullable();
            $table->string('razon_social',254)->nullable();
            $table->string('rfc',254)->nullable();
            $table->integer('estatus')->nullable();
            $table->datetime('timestamp')->nullable();
            $table->integer('registro')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contabilidad.hist_int_polizas_movimientos');
    }
}
