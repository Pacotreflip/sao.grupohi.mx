<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToHistIntPolizasMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad.hist_int_polizas_movimientos', function (Blueprint $table) {
            $table->foreign('id_hist_int_poliza')->references('id_hist_int_poliza')->on('contabilidad.hist_int_polizas');
            $table->foreign('id_int_poliza')->references('id_int_poliza')->on('contabilidad.int_polizas');
            $table->foreign('id_cuenta_contable')->references('id_int_cuenta_contable')->on('contabilidad.int_cuentas_contables');
            $table->foreign('id_tipo_cuenta_contable')->references('id_tipo_cuenta_contable')->on('contabilidad.int_tipos_cuentas_contables');
            $table->foreign('id_tipo_movimiento_poliza')->references('id')->on('contabilidad.tipos_movimientos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad.hist_int_polizas_movimientos', function (Blueprint $table) {
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_id_hist_int_poliza_id_foreign');
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_int_polizas_movimientos_id_int_poliza_foreign');
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_int_polizas_movimientos_id_cuenta_contable_foreign');
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_int_polizas_movimientos_id_tipo_cuenta_contable_foreign');
            $table->dropForeign('contabilidad_hist_int_polizas_movimientos_int_polizas_movimientos_id_tipo_movimiento_poliza_foreign');

        });
    }
}
