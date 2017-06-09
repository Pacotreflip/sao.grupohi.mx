<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToMovimientosPoliza extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos_poliza', function (Blueprint $table) {
            $table->foreign('id_poliza_tipo')->references('id')->on('poliza_tipo');
            $table->foreign('id_cuenta_contable')->references('id_int_cuenta_contable')->on('int_cuentas_contables');
            $table->foreign('id_tipo_movimiento')->references('id')->on('tipos_movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos_poliza', function (Blueprint $table) {
            $table->dropForeign('movimientos_poliza_id_poliza_tipo_foreign');
            $table->dropForeign('movimientos_poliza_id_cuenta_contable_foreign');
            $table->dropForeign('movimientos_poliza_id_tipo_movimiento_foreign');
        });
    }
}
