<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDboNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificaciones_html', function(Blueprint $table) {
            $table->dropColumn('idPolizas');
            $table->dropColumn('total_polizas');
            $table->dropColumn('estatus');
        });
    }
}
