<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintUniqueReclasificacionRechazada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion_rechazada', function (Blueprint $table) {
            $table->unique('id_solicitud_reclasificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion_rechazada', function (Blueprint $table) {
            $table->dropUnique('id_solicitud_reclasificacion');
        });
    }
}
