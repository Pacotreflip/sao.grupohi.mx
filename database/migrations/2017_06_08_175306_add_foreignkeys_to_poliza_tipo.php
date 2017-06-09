<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToPolizaTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poliza_tipo', function (Blueprint $table) {
            $table->foreign('id_transaccion_interfaz')->references('id_transaccion_interfaz')->on('int_transacciones_interfaz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poliza_tipo', function (Blueprint $table) {
            $table->dropForeign('poliza_tipo_id_transaccion_interfaz_foreign');
        });
    }
}
