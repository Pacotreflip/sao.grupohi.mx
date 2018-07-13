<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasSolicitudesRecursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cadeco')->create('Finanzas.solicitudes_recursos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo')->unsigned();
            $table->tinyInteger('semana');
            $table->smallInteger('anio');
            $table->smallInteger('consecutivo')->nullable();
            $table->string('folio');
            $table->integer('registro');
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_tipo')->references('id')->on('Finanzas.ctg_tipos_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cadeco')->drop('Finanzas.solicitudes_recursos');
    }
}
