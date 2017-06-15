<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id_proyecto');
            $table->string('base_datos',100)->nullable();
            $table->string('descripcion',45)->nullable();
            $table->string('descripcion_corta',50);
            $table->boolean('status')->nullable();
            $table->string('base_SAO',45);
            $table->string('empresa',45);
            $table->integer('tiene_logo')->nullable();
            $table->binary('logo')->nullable();
            $table->integer('nuevo_esquema');
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
        Schema::drop('proyectos');
    }
}
