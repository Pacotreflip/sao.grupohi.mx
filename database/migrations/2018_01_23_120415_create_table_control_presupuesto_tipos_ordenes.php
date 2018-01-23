<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableControlPresupuestoTiposOrdenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.tipos_ordenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descripcion")->unique();
            $table->integer('estatus');
            $table->timestamps();
            $table->unsignedInteger("id_tipo_cobrabilidad")->nullable();
            $table->foreign('id_tipo_cobrabilidad')
                ->references('id')
                ->on('ControlPresupuesto.tipo_cobrabilidad')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.tipos_ordenes');
    }
}
