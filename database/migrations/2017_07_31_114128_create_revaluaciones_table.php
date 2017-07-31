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
            $table->integer('id_moneda');
            $table->timestamps();

            $table->foreign('id_moneda')
                ->references('id_moneda')
                ->on('dbo.cambios');
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
