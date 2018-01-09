<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdObraToSolicitudReclasificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion', function (Blueprint $table) {
            $table->integer('id_obra')->unsigned();
            $table->foreign('id_obra')->references('id_obra')->on('dbo.obras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion', function (Blueprint $table) {
            $table->dropForeign('control_costos_id_obra_foreign');
            $table->dropColumn('id_obra');
        });
    }
}
