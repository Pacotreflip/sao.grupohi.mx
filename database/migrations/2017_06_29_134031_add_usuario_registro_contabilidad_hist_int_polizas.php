<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioRegistroContabilidadHistIntPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->string("usuario_registro",100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.hist_int_polizas', function (Blueprint $table) {
            $table->dropColumn("usuario_registro");
        });
    }
}
