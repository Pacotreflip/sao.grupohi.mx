<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaOriginalToContabilidadIntPolizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->dateTime('fecha_original')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.int_polizas', function (Blueprint $table) {
            $table->dropColumn('fecha_original');
        });
    }
}
