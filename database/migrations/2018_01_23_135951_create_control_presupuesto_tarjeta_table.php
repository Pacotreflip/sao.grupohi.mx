<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.tarjeta', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descripcion")->unique();
            $table->integer('estatus')->default(1);
            $table->unsignedInteger("id_obra");

            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('dbo.obras');

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
        Schema::drop('ControlPresupuesto.tarjeta');
    }
}
