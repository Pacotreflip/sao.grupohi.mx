<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToUsuariosProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuarios_proyectos', function (Blueprint $table) {
            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios_proyectos', function (Blueprint $table) {
            $table->dropForeign('usuarios_proyectos_id_proyecto_foreign');
        });
    }
}
