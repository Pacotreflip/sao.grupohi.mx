<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditReferencesInContabilidadMovimientosPolizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.movimientos_poliza', function (Blueprint $table) {
            $table->dropIndex('contabilidad_movimientos_poliza_id_cuenta_contable_index');
            $table->dropForeign('contabilidad_movimientos_poliza_id_cuenta_contable_foreign');
            $table->dropColumn('id_cuenta_contable');

            $table->integer('id_tipo_cuenta_contable')->unsigned();
            $table->foreign('id_tipo_cuenta_contable')->references('id_tipo_cuenta_contable')->on('Contabilidad.int_tipos_cuentas_contables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.movimientos_poliza', function (Blueprint $table) {
            $table->dropForeign('contabilidad_movimientos_poliza_id_tipo_cuenta_contable_foreign');
            $table->dropColumn('id_tipo_cuenta_contable');

            $table->integer('id_cuenta_contable')->unsigned()->index();
            $table->foreign('id_cuenta_contable')->references('id_int_cuenta_contable')->on('contabilidad.int_cuentas_contables')->onDelete('cascade');
        });
    }
}
