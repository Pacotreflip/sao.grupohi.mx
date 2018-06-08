<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableControlPresupuestoSolicitudCambiosPartidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlPresupuesto.solicitud_cambio_partidas', function (Blueprint $table) {
            $table->string('unidad')->nullable();
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
            $table->dropColumn('unidad');
        });
    }
}
