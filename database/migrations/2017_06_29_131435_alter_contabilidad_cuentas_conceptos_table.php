<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContabilidadCuentasConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.cuentas_conceptos', function(Blueprint $table) {
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
        Schema::table('Contabilidad.cuentas_conceptos', function(Blueprint $table) {
            $table->dropColumn('estatus');
        });
    }
}
