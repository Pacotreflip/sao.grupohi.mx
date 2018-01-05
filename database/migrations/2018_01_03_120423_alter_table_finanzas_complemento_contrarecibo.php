<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFinanzasComplementoContrarecibo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Finanzas.complemento_contrarecibo', function (Blueprint $table) {
            $table->dropColumn(['documentacion_completa']);
            $table->integer("docum_completa")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Finanzas.complemento_contrarecibo', function(Blueprint $table) {
            $table->dropColumn(['docum_completa']);
            $table->string("documentacion_completa");
        });
    }
}
