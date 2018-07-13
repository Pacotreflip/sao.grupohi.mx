<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasSolicitudesRecursosPartidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cadeco')->create('Finanzas.solicitudes_recursos_partidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud_recursos')->unsigned();
            $table->integer('id_transaccion')->unsigned();
            $table->float('monto');
            $table->float('monto_autorizado')->default(0);
            $table->integer('registro');
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_solicitud_recursos')->references('id')->on('Finanzas.solicitudes_recursos');
            $table->foreign('id_transaccion')->references('id_transaccion')->on('dbo.transacciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cadeco')->drop('Finanzas.solicitudes_recursos_partidas');
    }
}
