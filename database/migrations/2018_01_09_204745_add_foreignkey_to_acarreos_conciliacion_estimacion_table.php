<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToAcarreosConciliacionEstimacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Acarreos.conciliacion_estimacion', function (Blueprint $table) {
            $table->foreign('id_estimacion')->references('id_transaccion')->on('dbo.transacciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Acarreos.conciliacion_estimacion', function (Blueprint $table) {
            $table->dropForeign('Acarreos_conciliacion_estimacion_id_estimacion_foreign');
        });
    }
}
