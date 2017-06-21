<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntPolizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.int_polizas', function (Blueprint $table) {
            $table->increments('id_int_poliza');
            $table->integer('id_tipo_poliza')->nullable();
            $table->unsignedInteger('id_tipo_poliza_interfaz')->index();
            $table->unsignedInteger('id_tipo_poliza_contpaq')->index();
            $table->string('alias_bd_cadeco',254)->nullable();
            $table->unsignedInteger('id_obra_cadeco')->index();
            $table->unsignedInteger('id_transaccion_sao')->index();
            $table->integer('id_obra_contpaq')->nullable();
            $table->string('alias_bd_contpaq',254)->nullable();
            $table->datetime('fecha')->nullable();
            $table->string('concepto',4000)->nullable();
            $table->float('total')->nullable();
            $table->float('cuadre');
            $table->datetime('timestamp_registro')->nullable();
            $table->integer('estatus')->nullable();
            $table->datetime('timestamp_lanzamiento')->nullable();
            $table->string('usuario_lanzamiento',50)->nullable();
            $table->integer('id_poliza_contpaq')->nullable();
            $table->string('poliza_contpaq',254)->nullable();
            $table->integer('registro');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contabilidad.int_polizas');
    }
}
