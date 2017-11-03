<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTesoreriaMovimientosBancarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tesoreria.movimientos_bancarios', function (Blueprint $table) {
            $table->increments('id_movimiento_bancario');
            $table->unsignedInteger("id_tipo_movimiento")->nullable();
            $table->unsignedInteger("estatus")->nullable();
            $table->unsignedInteger("id_cuenta")->nullable();
            $table->unsignedInteger("impuesto")->nullable();
            $table->float("importe")->nullable();
            $table->text("observaciones")->nullable();
            $table->unsignedInteger("registro")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Tesoreria.movimientos_bancarios');
    }
}
