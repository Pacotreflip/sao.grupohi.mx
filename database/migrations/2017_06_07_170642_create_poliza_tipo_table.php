<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolizaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaccion_interfaz')->index();
            $table->integer('registro');
            $table->integer('aprobo')->nullable();
            $table->integer('cancelo')->nullable();
            $table->string('motivo')->nullable();
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
        Schema::drop('contabilidad.poliza_tipo');
    }
}
