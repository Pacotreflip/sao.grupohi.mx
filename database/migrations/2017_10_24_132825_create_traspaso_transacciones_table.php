<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraspasoTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traspaso_transacciones', function (Blueprint $table) {
            $table->increments('id_traspaso_transaccion');
            $table->integer("id_traspaso");
            $table->integer("id_transaccion")->unsigned();
            $table->integer("tipo_transaccion")->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_traspaso')
                ->references('id_traspaso')
                ->on('Tesoreria.traspaso_cuentas')
                ->onDelete('no action');

            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('transacciones')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('traspaso_transacciones');
    }
}
