<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdMovimientoBancarioToHistIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->unsignedInteger('id_movimiento_bancario')->nullable();
            $table->foreign('id_movimiento_bancario')
                ->references('id_movimiento_bancario')
                ->on('Tesoreria.movimientos_bancarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->dropForeign('contabilidad_hist_int_polizas_id_movimiento_bancario_foreign');
            $table->dropColumn('id_movimiento_bancario');
        });
    }
}
