<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoTarjetaConceptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.concepto_tarjeta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estatus')->default(1);
            $table->timestamps();
            $table->unsignedInteger("id_tarjeta");
            $table->unsignedInteger("id_concepto");
            $table->unsignedInteger("id_obra");

            $table->foreign('id_tarjeta')
                ->references('id')
                ->on('ControlPresupuesto.tarjeta')
                ->onDelete('cascade');

            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('dbo.conceptos')
                ->onDelete('cascade');

            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('dbo.obras');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.concepto_tarjeta');
    }
}
