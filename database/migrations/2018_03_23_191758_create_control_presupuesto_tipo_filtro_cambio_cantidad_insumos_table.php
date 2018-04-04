<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoTipoFiltroCambioCantidadInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.filtro_cambio_cantidad_insumos', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("id_solicitud_cambio");
            $table->unsignedInteger("id_tipo_filtro");

            $table->foreign('id_solicitud_cambio')
                ->references('id')
                ->on('ControlPresupuesto.solicitud_cambio');

            $table->foreign('id_tipo_filtro')
                ->references('id')
                ->on('ControlPresupuesto.tipo_filtro');
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
        Schema::drop('ControlPresupuesto.filtro_cambio_cantidad_insumos');
    }
}
