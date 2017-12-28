<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionCierresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Configuracion.cierres', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('registro');
            $table->timestamps();
            $table->integer('id_proyecto')->unsigned();
            $table->integer('id_obra');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Configuracion.cierres');
    }
}
