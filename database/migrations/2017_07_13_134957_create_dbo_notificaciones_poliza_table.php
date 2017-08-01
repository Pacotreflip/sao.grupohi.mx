<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDboNotificacionesPolizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dbo.notificaciones_polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_notificacion')->unsigned();
            $table->integer('id_int_poliza')->unsigned();
            $table->string('tipo_poliza');
            $table->string('concepto');
            $table->string('cuadre');
            $table->date('fecha_solicitud');
            $table->string('usuario_solicita');
            $table->string('estatus');
            $table->string('poliza_contpaq');

            $table->foreign('id_notificacion')
                ->references('id')
                ->on('dbo.notificaciones')
                ->onDelete('cascade');

            $table->foreign('id_int_poliza')
                ->references('id_int_poliza')
                ->on('Contabilidad.int_polizas')
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
        Schema::drop('dbo.notificaciones_polizas');
    }
}
