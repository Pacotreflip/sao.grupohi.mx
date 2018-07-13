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
        Schema::connection('cadeco')->table('Finanzas.complemento_factura', function (Blueprint $table) {
            $table->string('fecha_referencia')->nullable();
            $table->string('vencimiento_referencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cadeco')->table('Finanzas.complemento_factura', function (Blueprint $table) {
            $table->dropColumn('fecha_referencia');
            $table->dropColumn('vencimiento_referencia');
        });
    }
}
