<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdSolicitudReclasificacionPartidaToHistIntPolizasMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.hist_int_polizas_movimientos', function (Blueprint $table) {
            $table->unsignedInteger('id_solicitud_reclasificacion_partida')->nullable();
            $table->foreign('id_solicitud_reclasificacion_partida')
                ->references('id')
                ->on('ControlCostos.solicitud_reclasificacion_partidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.hist_int_polizas_movimientos', function (Blueprint $table) {
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_id_solicitud_reclasificacion_partida_foreign');
            $table->dropColumn('id_solicitud_reclasificacion_partida');
        });
    }
}
