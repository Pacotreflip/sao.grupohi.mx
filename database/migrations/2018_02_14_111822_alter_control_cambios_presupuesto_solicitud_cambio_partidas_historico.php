<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterControlCambiosPresupuestoSolicitudCambioPartidasHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlPresupuesto.solicitud_cambio_partidas_historico', function (Blueprint $table) {
            $table->float("precio_unitario_original")->nullable();
            $table->float("precio_unitario_actualizado")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ControlPresupuesto.solicitud_cambio_partidas_historico', function (Blueprint $table) {
            $table->dropColumn('precio_unitario_original');
            $table->dropColumn('precio_unitario_actualizado');

        });
    }
}
