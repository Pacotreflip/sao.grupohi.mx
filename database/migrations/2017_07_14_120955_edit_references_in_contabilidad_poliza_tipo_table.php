<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditReferencesInContabilidadPolizaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.poliza_tipo_sao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('estatus');
            $table->integer('id_obra');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_obra')->references('id_obra')->on('dbo.obras');
        });

        Schema::table('Contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->dropIndex('contabilidad_poliza_tipo_id_transaccion_interfaz_index');
            $table->dropForeign('contabilidad_poliza_tipo_id_transaccion_interfaz_foreign');
            $table->dropColumn('id_transaccion_interfaz');

            $table->integer('id_poliza_tipo_sao')->unsigned()->nullable();
            $table->foreign('id_poliza_tipo_sao')->references('id')->on('Contabilidad.poliza_tipo_sao')->onDelete('cascade');
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
            $table->dropForeign('contabilidad_poliza_tipo_id_poliza_tipo_sao_foreign');
            $table->dropColumn('id_poliza_tipo_sao');

            $table->integer('id_transaccion_interfaz')->unsigned()->index();
            $table->foreign('id_transaccion_interfaz')->references('id_transaccion_interfaz')->on('Contabilidad.int_transacciones_interfaz')->onDelete('cascade');
        });

        Schema::drop('Contabilidad.poliza_tipo_sao');
    }
}
