<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTraspasoCuentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tesoreria.traspaso_cuentas', function (Blueprint $table) {
            $table->float('importe')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tesoreria.traspaso_cuentas', function(Blueprint $table) {
            $table->unsignedInteger('importe')->change();
        });
    }
}
