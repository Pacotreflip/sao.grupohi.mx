<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToIntCuentasContables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('int_cuentas_contables', function (Blueprint $table) {
            $table->foreign('id_obra')->references('id_obra')->on('obras');
            $table->foreign('id_int_tipo_cuenta_contable')->references('id_tipo_cuenta_contable')->on('int_tipos_cuentas_contables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('int_cuentas_contables', function (Blueprint $table) {
            $table->dropForeign('int_cuentas_contables_id_obra_foreign');
            $table->dropForeign('int_cuentas_contables_id_int_tipo_cuenta_contable_foreign');
        });
    }
}
