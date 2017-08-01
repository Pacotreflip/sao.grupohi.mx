<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContabilidadRevaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.revaluaciones', function(Blueprint $table) {
            $table->integer('user_registro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.revaluaciones', function (Blueprint $table) {
            $table->dropColumn('user_registro');
        });
    }
}
