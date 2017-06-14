<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntTransaccionesInterfazTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.int_transacciones_interfaz', function (Blueprint $table) {
            $table->increments('id_transaccion_interfaz');
            $table->string('descripcion',254);
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
        Schema::drop('contabilidad.int_transacciones_interfaz');
    }
}
