<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIntTiposCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_tipos_cuentas_contables', function (Blueprint $table) {
            $table->integer('id_obra')->nullable();
            $table->integer('registro')->nullable();
            $table->string('motivo')->nullable();
            $table->softDeletes();

            $table->foreign('id_obra')->references('id_obra')->on('dbo.obras');

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
            $table->dropForeign('id_obra');
            $table->removeColumn(['id_obra', 'registro', 'motivo']);
            $table->dropSoftDeletes();
        });
    }
}
