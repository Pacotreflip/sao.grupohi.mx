<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosProyectosModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_proyectos_modulos', function (Blueprint $table) {
            $table->integer('id_usuario');
            $table->unsignedInteger('id_proyecto')->index();
            $table->integer('id_modulo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuarios_proyectos_modulos');
    }
}
