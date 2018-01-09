<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlcostosSolicitudReclasificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlCostos.solicitud_reclasificacion', function (Blueprint $table) {

            $table->increments('id');
            $table->text("motivo");
            $table->unsignedInteger("estatus");
            $table->unsignedInteger("registro");
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
        Schema::drop('ControlCostos.solicitud_reclasificacion');
    }
}
