<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetencionDatosContablesObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.datos_contables_obra', function (Blueprint $table) {
            $table->boolean('retencion_antes_iva')->default(true);
            $table->boolean('amortizacion_antes_iva')->default(true);
            $table->boolean('deductiva_antes_iva')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.datos_contables_obra', function (Blueprint $table) {
            $table->dropColumn('retencion_antes_iva');
            $table->dropColumn('amortizacion_antes_iva');
            $table->dropColumn('deductiva_antes_iva');
        });
    }
}
