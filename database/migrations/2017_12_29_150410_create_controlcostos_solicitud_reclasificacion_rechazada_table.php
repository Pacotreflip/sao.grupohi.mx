<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlcostosSolicitudReclasificacionRechazadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlCostos.solicitud_reclasificacion_rechazada', function (Blueprint $table) {
            $table->unsignedInteger('id_solicitud_reclasificacion');
            $table->integer('id_rechazo');
            $table->text('motivo');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_solicitud_reclasificacion')
                ->references('id')
                ->on('ControlCostos.solicitud_reclasificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlCostos.solicitud_reclasificacion_rechazada');
    }
}
