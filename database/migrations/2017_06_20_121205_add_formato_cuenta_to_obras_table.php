<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormatoCuentaToObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dbo.obras', function (Blueprint $table) {
            $table->string('FormatoCuenta')->nullable();
            $table->string('FormatoCuentaRegExp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dbo.obras', function (Blueprint $table) {
            $table->removeColumn('FormatoCuenta');
            $table->removeColumn('FormatoCuentaRegExp');
        });
    }
}
