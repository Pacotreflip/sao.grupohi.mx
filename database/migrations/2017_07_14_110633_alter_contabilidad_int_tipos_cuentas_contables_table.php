<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContabilidadIntTiposCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_tipos_cuentas_contables', function(Blueprint $table) {
            $table->integer('id_naturaleza_poliza')->unsigned()->nullable();
            $table->foreign('id_naturaleza_poliza')->references('id_naturaleza_poliza')->on('Contabilidad.naturaleza_poliza');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_tipos_cuentas_contables', function(Blueprint $table) {
            $table->integer('id_naturaleza_poliza')->unsigned();
        });

    }
}
