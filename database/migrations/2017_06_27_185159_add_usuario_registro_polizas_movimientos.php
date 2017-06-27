<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioRegistroPolizasMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas_movimientos', function (Blueprint $table) {
            $table->string("usuario_registro",100);
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
            $table->dropColumn("usuario_registro");
        });
    }
}
