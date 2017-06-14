<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToDatosContablesObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad.datos_contables_obra', function (Blueprint $table) {
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
        Schema::table('contabilidad.datos_contables_obra', function (Blueprint $table) {
            $table->dropForeign('id_obra_foreign');
        });
    }
}
