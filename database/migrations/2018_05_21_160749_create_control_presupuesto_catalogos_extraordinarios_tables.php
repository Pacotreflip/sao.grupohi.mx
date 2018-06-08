<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoCatalogosExtraordinariosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.catalogo_extraordinarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descripcion")->unique();
            $table->integer('tipo_costo');
            $table->integer('creado_por');
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
        Schema::drop('ControlPresupuesto.catalogo_extraordinarios');
    }
}
