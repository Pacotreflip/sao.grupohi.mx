<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableControlPresupuestoSolicitudCambio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.solicitud_cambio', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime("fecha_solicitud");
            $table->integer("id_solicita");
            $table->unsignedInteger("id_estatus");
            $table->unsignedInteger("id_tipo_orden");

            $table->foreign('id_estatus')
                ->references('id')
                ->on('ControlPresupuesto.estatus');

            $table->foreign('id_tipo_orden')
                ->references('id')
                ->on('ControlPresupuesto.tipos_ordenes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.solicitud_cambio');
    }
}
