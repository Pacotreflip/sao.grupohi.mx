<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevaluacionTransaccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.revaluacion_transaccion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_revaluacion');
            $table->unsignedInteger('id_transaccion');

            $table->foreign('id_revaluacion')
                ->references('id')
                ->on('Contabilidad.revaluaciones');

            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.revaluacion_transaccion');
    }
}
