<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropConfiguracionCierresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('seguridad')->drop('Configuracion.cierres');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { Schema::connection('seguridad')->create('Configuracion.cierres', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('anio');
        $table->integer('mes');
        $table->integer('registro');
        $table->timestamps();
        $table->integer('id_proyecto')->unsigned();
        $table->integer('id_obra');
        $table->softDeletes();

        $table->foreign('id_proyecto')
            ->references('id')
            ->on('dbo.proyectos')
            ->onDelete('cascade');
    });

    }
}
