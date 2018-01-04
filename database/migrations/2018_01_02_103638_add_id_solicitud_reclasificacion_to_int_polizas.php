<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdSolicitudReclasificacionToIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->unsignedInteger('id_solicitud_reclasificacion')->nullable();
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
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->dropForeign('contabilidad_int_polizas_id_solicitud_reclasificacion_foreign');
            $table->dropColumn('id_solicitud_reclasificacion');
        });
    }
}
