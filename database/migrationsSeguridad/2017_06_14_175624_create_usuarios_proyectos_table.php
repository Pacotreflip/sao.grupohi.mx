<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_proyectos', function (Blueprint $table) {

            $table->integer('id_usuario');
            $table->unsignedInteger('id_proyecto')->index();
            $table->integer('id_usuario_intranet');
            $table->integer('registro');
            $table->integer('elimino')->nullable();
            $table->integer('motivo')->nullable();
            $table->integer('estatus')->nullable();
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
        Schema::drop('usuarios_proyectos');
    }
}
