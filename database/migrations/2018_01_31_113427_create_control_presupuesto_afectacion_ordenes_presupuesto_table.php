<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoAfectacionOrdenesPresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.afectacion_ordenes_presupuesto', function (Blueprint $table) {
            $table->unsignedInteger("id_tipo_orden");
            $table->unsignedInteger("id_base_presupuesto");

            $table->foreign('id_tipo_orden')
                ->references('id')
                ->on('ControlPresupuesto.tipos_ordenes');

            $table->foreign('id_base_presupuesto')
                ->references('id')
                ->on('ControlPresupuesto.bases_presupuesto');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.afectacion_ordenes_presupuesto');
    }
}
