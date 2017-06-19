<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdObraToPolizaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->integer('id_obra')->unsigned()->nullable();
            $table->foreign('id_obra')->references('id_obra')->on('dbo.obras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->dropForeign('contabilidad_poliza_tipo_id_obra_foreign');
            $table->dropColumn('id_obra');
        });
    }
}
