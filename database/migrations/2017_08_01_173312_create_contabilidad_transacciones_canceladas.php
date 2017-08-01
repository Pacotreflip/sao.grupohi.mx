<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadTransaccionesCanceladas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.transacciones_canceladas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaccion');
            $table->string("registro",100);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('transacciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.transacciones_canceladas');
    }
}
