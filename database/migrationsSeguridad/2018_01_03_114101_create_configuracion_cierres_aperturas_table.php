<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionCierresAperturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('seguridad')->create('Configuracion.cierres_aperturas', function (Blueprint $table) {
            $table->unsignedInteger('id_cierre');
            $table->text('motivo');
            $table->integer('registro');
            $table->timestamp('inicio_apertura');
            $table->timestamp('fin_apertura')->nullable();
            $table->boolean('estatus');

            $table->foreign('id_cierre')
                ->references('id')
                ->on('Configuracion.cierres')
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
        Schema::connection('seguridad')->drop('Configuracion.cierres_aperturas');
    }
}
