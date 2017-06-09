<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosPolizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_poliza', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_poliza_tipo')->index();
            $table->unsignedInteger('id_cuenta_contable')->index();
            $table->unsignedInteger('id_tipo_movimiento')->index();
            $table->integer('registro');
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
        Schema::drop('movimientos_poliza');
    }
}
