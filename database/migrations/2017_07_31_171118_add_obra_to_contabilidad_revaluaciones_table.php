<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObraToContabilidadRevaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad.revaluaciones', function (Blueprint $table) {
            $table->integer('id_obra')->unsigned();

            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('dbo.obras')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad.revaluaciones', function (Blueprint $table) {

            $table->dropForeign('contabilidad_revaluaciones_id_obra_foreign');
            $table->dropColumn('id_obra');
        });
    }
}
