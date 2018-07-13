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
        Schema::connection('cadeco')->create('Finanzas.transacciones_rubros', function (Blueprint $table) {
            $table->integer('id_transaccion')->unsigned();
            $table->integer('id_rubro')->unsigned();

            $table->primary('id_transaccion');

            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
            $table->foreign('id_rubro')
                ->references('id')
                ->on('Finanzas.rubros');

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
