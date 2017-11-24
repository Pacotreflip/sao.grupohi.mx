<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImporteIdMonedaToTableContabilidadIntPolizasMovimientosCostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas_movimientos_costos', function (Blueprint $table) {
            $table->unsignedInteger('id_moneda')->nullable();
            $table->float('importe');
            
            $table->foreign('id_moneda')
                ->references('id_moneda')
                ->on('monedas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_polizas_movimientos_costos', function (Blueprint $table) {
            //
        });
    }
}
