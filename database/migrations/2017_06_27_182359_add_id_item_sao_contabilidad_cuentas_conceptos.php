<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdItemSaoContabilidadCuentasConceptos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas_movimientos', function (Blueprint $table) {
            $table->integer('id_item_sao')->unsigned()->nullable()->after("id_transaccion_sao");
            $table->foreign('id_item_sao')->references('id_item')->on('dbo.items');
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
            $table->dropForeign('contabilidad_int_polizas_movimientos_id_item_sao_foreign');
            $table->dropColumn('id_item_sao');
        });
    }
}
