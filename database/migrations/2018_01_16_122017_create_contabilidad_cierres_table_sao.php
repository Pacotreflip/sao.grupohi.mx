<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCierresTableSao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cierres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anio');
            $table->integer('mes');
            $table->integer('registro');
            $table->timestamps();
            $table->integer('id_obra')->unsigned();
            $table->softDeletes();

            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('dbo.obras')
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
        Schema::drop('Contabilidad.cierres');
    }

}
