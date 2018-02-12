<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlCambiosPartidasInsumosAgrupados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.partidas_insumos_agrupados', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("id_solicitud_cambio");
            $table->unsignedInteger("id_concepto");

            $table->foreign('id_solicitud_cambio')
                ->references('id')
                ->on('ControlPresupuesto.solicitud_cambio');

            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('dbo.conceptos');
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
        Schema::drop('ControlPresupuesto.partidas_insumos_agrupados');
    }
}
