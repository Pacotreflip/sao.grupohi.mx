<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlcostosSolicitudReclasificacionPartidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlCostos.solicitud_reclasificacion_partidas', function (Blueprint $table) {
            $table->increments('id_partida');
            $table->unsignedInteger("id_solicitud_reclasificacion")->nullable();
            $table->unsignedInteger("id_item")->nullable();
            $table->unsignedInteger("id_concepto_original")->nullable();
            $table->unsignedInteger("id_concepto_nuevo")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_concepto_original')
                ->references('id_concepto')
                ->on('dbo.conceptos')
                ->onDelete('no action');

            $table->foreign('id_concepto_nuevo')
                ->references('id_concepto')
                ->on('dbo.conceptos')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlCostos.solicitud_reclasificacion_partidas');
    }
}
