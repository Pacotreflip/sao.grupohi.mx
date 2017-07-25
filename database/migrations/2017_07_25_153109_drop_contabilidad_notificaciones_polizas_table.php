<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropContabilidadNotificacionesPolizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.notificaciones_polizas', function (Blueprint $table) {
            Schema::drop('Contabilidad.notificaciones_polizas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('Contabilidad.notificaciones_polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_notificacion')->unsigned();
            $table->integer('id_int_poliza')->unsigned();
            $table->string('tipo_poliza');
            $table->string('concepto');
            $table->string('cuadre');
            $table->date('fecha_solicitud');
            $table->integer('usuario_solicita');
            $table->string('estatus');

            $table->string('poliza_contpaq')->nullable();

            $table->foreign('id_int_poliza')
                ->references('id_int_poliza')
                ->on('Contabilidad.int_polizas')
                ->onDelete('cascade');
        });
    }
}
