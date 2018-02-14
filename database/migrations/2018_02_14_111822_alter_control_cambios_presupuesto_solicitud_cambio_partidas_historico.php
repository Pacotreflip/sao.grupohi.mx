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
            $table->unsignedInteger('id_partidas_insumos_agrupados')->nullable();


            $table->foreign('id_partidas_insumos_agrupados')
                ->references('id')
                ->on('ControlPresupuesto.partidas_insumos_agrupados');

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
            $table->dropForeign('controlPresupuesto_solicitud_cambio_partidas_historico_id_partidas_insumos_agrupados_foreign');
            $table->dropColumn('id_partidas_insumos_agrupados');

        });
    }
}
