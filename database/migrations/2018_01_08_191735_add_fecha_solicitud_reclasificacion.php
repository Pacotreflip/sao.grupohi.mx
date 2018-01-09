<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaSolicitudReclasificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion', function (Blueprint $table) {
            $table->timestamp('fecha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ControlCostos.solicitud_reclasificacion', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
}
