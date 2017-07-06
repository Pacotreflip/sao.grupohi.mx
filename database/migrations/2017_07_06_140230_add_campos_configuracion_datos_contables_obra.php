<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposConfiguracionDatosContablesObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.datos_contables_obra', function (Blueprint $table) {
            $table->boolean('manejo_almacenes')->default('0');
            $table->boolean('costo_en_tipo_gasto')->default('0');
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
            $table->dropColumn('manejo_almacenes');
            $table->dropColumn('costo_en_tipo_gasto');
        });
    }
}
