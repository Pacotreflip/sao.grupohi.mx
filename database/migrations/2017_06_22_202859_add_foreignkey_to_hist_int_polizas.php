<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddForeignkeyToHistIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->foreign('id_int_poliza')->references('id_int_poliza')->on('contabilidad.int_polizas');
            $table->foreign('id_tipo_poliza_interfaz')->references('id_transaccion_interfaz')->on('contabilidad.int_transacciones_interfaz');
            $table->foreign('id_tipo_poliza_contpaq')->references('id_int_tipo_poliza_contpaq')->on('contabilidad.int_tipos_polizas_contpaq');
            $table->foreign('id_obra_cadeco')->references('id_obra')->on('dbo.obras');
            $table->foreign('id_transaccion_sao')->references('id_transaccion')->on('dbo.transacciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->dropForeign('contabilidad.hist_int_polizas_id_int_poliza_foreign');
            $table->dropForeign('contabilidad.hist_int_polizas_id_tipo_poliza_interfaz_foreign');
            $table->dropForeign('contabilidad.hist_int_polizas_id_int_tipo_poliza_contpaq_foreign');
            $table->dropForeign('contabilidad.hist_int_polizas_id_obra_cadeco_foreign');
            $table->dropForeign('contabilidad.hist_int_polizas_id_transaccion_sao_foreign');
        });
    }
}
