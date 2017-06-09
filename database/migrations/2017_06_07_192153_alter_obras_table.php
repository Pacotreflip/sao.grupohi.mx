<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obras', function (Blueprint $table) {
            $table->string('BDContPaq')->nullable();
            $table->integer('NumobraContPaq')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obras', function (Blueprint $table) {
            $table->dropColumn(['BDContPaq', 'NumobraContPaq']);
        });
    }
}
