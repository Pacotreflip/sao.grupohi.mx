<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFinanzasComplementoContrarecibo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Finanzas.complemento_contrarecibo', function (Blueprint $table) {
            $table->increments('id');
            $table->string("documentacion_completa");
            $table->unsignedInteger('id_transaccion')->index();
            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Finanzas.complemento_contrarecibo');
    }
}
