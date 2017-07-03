<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoToContabilidadIntTiposCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_tipos_cuentas_contables', function (Blueprint $table) {
            $table->integer('tipo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_tipos_cuentas_contables', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
