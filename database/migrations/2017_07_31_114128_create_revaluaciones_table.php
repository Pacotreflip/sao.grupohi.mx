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
        Schema::create('Contabilidad.revaluacion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->float('tipo_cambio');
            $table->integer('id_moneda')->unsigned();
            $table->timestamps();

            $table->foreign('id_moneda')
                ->references('id_moneda')
                ->on('dbo.monedas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.revaluacion');
    }
}