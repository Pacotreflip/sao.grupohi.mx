<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdCancelacionToIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->unsignedInteger('id_transaccion_cancelada')->nullable();
            $table->foreign('id_transaccion_cancelada')
                ->references('id')
                ->on('Contabilidad.transacciones_canceladas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->dropForeign('contabilidad_int_polizas_id_transaccion_cancelada_foreign');
            $table->dropColumn('id_transaccion_cancelada');
        });
    }
}
