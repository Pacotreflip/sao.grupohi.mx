<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdTraspasoToIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->unsignedInteger('id_traspaso')->nullable();
            $table->foreign('id_traspaso')
                ->references('id_traspaso')
                ->on('Tesoreria.traspaso_cuentas');
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
            $table->dropForeign('contabilidad_int_polizas_id_traspaso_foreign');
            $table->dropColumn('id_transaccion_cancelada');
        });
    }
}
