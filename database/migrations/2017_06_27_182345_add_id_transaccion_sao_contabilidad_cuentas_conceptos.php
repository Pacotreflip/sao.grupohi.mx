<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdTransaccionSaoContabilidadCuentasConceptos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas_movimientos', function (Blueprint $table) {
            $table->integer('id_transaccion_sao')->unsigned()->nullable();
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
        Schema::table('Contabilidad.int_polizas_movimientos', function (Blueprint $table) {
            $table->dropForeign('contabilidad_int_polizas_movimientos_id_transaccion_foreign');
            $table->dropColumn('id_transaccion_sao');
        });
    }
}
