<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoSolicitudCambioAplicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.solicitud_cambio_aplicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_base_presupuesto');
            $table->unsignedInteger('id_solicitud_cambio');
            $table->integer('registro');
            $table->timestamps();

            $table->foreign('id_base_presupuesto')
                ->references('id')
                ->on('ControlPresupuesto.bases_presupuesto');

            $table->foreign('id_solicitud_cambio')
                ->references('id')
                ->on('ControlPresupuesto.solicitud_cambio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.solicitud_cambio_aplicacion');
    }
}
