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

        Schema::create('ControlPresupuesto.catalogo_extraordinarios_partidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_catalogo_extraordinarios');
            $table->integer('id_material')->nullable();
            $table->string("nivel");
            $table->string("descripcion");
            $table->string("unidad")->nullable();
            $table->float('cantidad_presupuestada')->nullable();
            $table->float("precio_unitario")->nullable();
            $table->float("monto_presupuestado")->nullable();
            $table->timestamps();

            $table->foreign('id_catalogo_extraordinarios')
                ->references('id')
                ->on('ControlPresupuesto.catalogo_extraordinarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.catalogo_extraordinarios_partidas');
    }
}
