<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeidaToNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dbo.notificaciones', function (Blueprint $table) {
            $table->boolean('leida')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dbo.notificaciones', function (Blueprint $table) {
            $table->dropColumn('leida');
        });
    }
}
