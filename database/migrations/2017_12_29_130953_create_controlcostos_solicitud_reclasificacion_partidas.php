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
            $table->increments('id');
            $table->unsignedInteger("id_solicitud_reclasificacion");
            $table->unsignedInteger("id_item");
            $table->unsignedInteger("id_concepto_original");
            $table->unsignedInteger("id_concepto_nuevo");
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_solicitud_reclasificacion')
                ->references('id')
                ->on('ControlCostos.solicitud_reclasificacion');
            $table->foreign('id_item')
                ->references('id_item')
                ->on('items');
            
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
