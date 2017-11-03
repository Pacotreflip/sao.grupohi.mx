<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMovimientoTransacciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tesoreria.movimiento_transacciones', function (Blueprint $table) {
            $table->increments('id_movimiento_transaccion');
            $table->integer("id_movimiento_bancario");
            $table->unsignedInteger("id_transaccion")->nullable();
            $table->unsignedInteger("tipo_transaccion")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_movimiento_bancario')
                ->references('id_movimiento_bancario')
                ->on('Tesoreria.movimientos_bancarios')
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
        Schema::drop('Tesoreria.movimiento_transacciones');
    }
}
