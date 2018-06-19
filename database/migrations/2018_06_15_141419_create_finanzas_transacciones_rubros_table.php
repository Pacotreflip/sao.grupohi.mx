<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasTransaccionesRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Finanzas.transacciones_rubros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_transaccion');
            $table->integer('id_rubro');
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
        Schema::connection('cadeco')->drop('Finanzas.transacciones_rubros');
    }
}
