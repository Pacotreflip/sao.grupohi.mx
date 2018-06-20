<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFinanzasComplementoFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Finanzas.complemento_factura', function (Blueprint $table) {
            $table->string('fecha_inicio_referencia')->nullable();
            $table->string('fecha_fin_referencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Finanzas.complemento_factura', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio_referencia');
            $table->dropColumn('fecha_fin_referencia');
        });
    }
}
