<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropContabilidadNotificacionesPolizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.notificaciones_polizas', function (Blueprint $table) {
            $table->dropColumn('poliza_contpaq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.notificaciones_polizas', function (Blueprint $table) {

            $table->string('poliza_contpaq')->nullable();
        });
    }
}
