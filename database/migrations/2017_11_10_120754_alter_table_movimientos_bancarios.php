<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimientosBancarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tesoreria.movimientos_bancarios', function (Blueprint $table) {
            $table->float('impuesto')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tesoreria.movimientos_bancarios', function(Blueprint $table) {
            $table->unsignedInteger('impuesto')->change();
        });
    }
}
