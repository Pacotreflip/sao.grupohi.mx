<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIntPolizasValido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.int_polizas_valido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_int_poliza');
            $table->integer('valido');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_int_poliza')
                ->references('id_int_poliza')
                ->on('Contabilidad.int_polizas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.int_polizas_valido');
    }
}
