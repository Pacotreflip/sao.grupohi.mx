<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntPolizasMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.int_polizas_movimientos', function (Blueprint $table) {

            $table->increments(' id_int_poliza_movimiento');
            $table->unsignedInteger('id_int_poliza')->index();
            $table->unsignedInteger('id_tipo_cuenta_contable')->index();
            $table->unsignedInteger('id_cuenta_contable')->index();
            $table->integer('cuenta_contable');
            $table->float('importe',100);
            $table->unsignedInteger('id_tipo_movimiento_poliza')->index();
            $table->string('referencia',10);
            $table->string('concepto',100);
            $table->integer('id_empresa_cadeco');
            $table->string('razon_social',254);
            $table->string('rfc',254);
            $table->integer('estatus');
            $table->datetime('timestamp');
            $table->integer('registro');
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
        Schema::drop('contabilidad.int_polizas_movimientos');
    }
}
