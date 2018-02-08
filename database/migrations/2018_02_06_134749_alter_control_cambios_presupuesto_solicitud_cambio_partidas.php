<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterControlCambiosPresupuestoSolicitudCambioPartidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlPresupuesto.solicitud_cambio_partidas', function (Blueprint $table) {
            $table->unsignedInteger("id_material")->nullable();
            $table->string("nivel")->nullable();
            $table->float("precio_unitario_original")->nullable();
            $table->float("precio_unitario_nuevo")->nullable();

            $table->float("rendimiento_original")->nullable();
            $table->float("rendimiento_nuevo")->nullable();

            $table->foreign('id_material')
                ->references('id_material')
                ->on('dbo.materiales');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ControlPresupuesto.solicitud_cambio_partidas', function (Blueprint $table) {
            $table->dropColumn('nivel');
            $table->dropColumn('precio_unitario_original');
            $table->dropColumn('precio_unitario_nuevo');
            $table->dropColumn('rendimiento_nuevo');
            $table->dropColumn('rendimiento_original');

            $table->dropForeign('controlPresupuesto_solicitud_cambio_partidas_id_material_foreign');
            $table->dropColumn('id_material');
        });
    }
}
