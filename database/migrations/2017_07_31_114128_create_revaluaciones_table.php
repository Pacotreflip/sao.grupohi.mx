<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.revaluaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->float('tipo_cambio');
            $table->integer('id_moneda')->unsigned();
            $table->integer('user_registro');
            $table->integer('id_obra')->unsigned();
            $table->timestamps();

            $table->foreign('id_moneda')
                ->references('id_moneda')
                ->on('dbo.monedas');

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
        Schema::drop('Contabilidad.revaluaciones');
    }
}