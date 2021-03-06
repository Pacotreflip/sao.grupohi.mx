<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContabilidadIntCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_cuentas_contables', function(Blueprint $table) {
            $table->integer('estatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_cuentas_contables', function(Blueprint $table) {
            $table->dropColumn('estatus');
        });
    }
}
