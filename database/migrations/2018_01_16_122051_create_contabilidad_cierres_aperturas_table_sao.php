<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCierresAperturasTableSao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cierres_aperturas', function (Blueprint $table) {
            $table->unsignedInteger('id_cierre');
            $table->text('motivo');
            $table->integer('registro');
            $table->timestamp('inicio_apertura');
            $table->timestamp('fin_apertura')->nullable();
            $table->boolean('estatus');

            $table->foreign('id_cierre')
                ->references('id')
                ->on('Contabilidad.cierres')
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
        Schema::drop('Contabilidad.cierres_aperturas');
    }
}
