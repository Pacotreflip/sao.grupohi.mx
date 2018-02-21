<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableControlPresupuestoSolicitudCambioPartidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.solicitud_cambio_partidas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("id_solicitud_cambio");
            $table->unsignedInteger("id_tipo_orden");
            $table->unsignedInteger("id_tarjeta")->nullable();
            $table->unsignedInteger("id_concepto")->nullable();
            $table->float("cantidad_presupuestada_original")->nullable();
            $table->float("cantidad_presupuestada_nueva")->nullable();
            $table->float('variacion_volumen')->nullable();
            $table->text('descripcion')->nullable();
            $table->float('monto_presupuestado')->nullable();

            $table->unsignedInteger("id_material")->nullable();
            $table->string("nivel")->nullable();
            $table->float("precio_unitario_original")->nullable();
            $table->float("precio_unitario_nuevo")->nullable();

            $table->float("rendimiento_original")->nullable();
            $table->float("rendimiento_nuevo")->nullable();

            $table->foreign('id_material')
                ->references('id_material')
                ->on('dbo.materiales');

            $table->foreign('id_solicitud_cambio')
                ->references('id')
                ->on('ControlPresupuesto.solicitud_cambio');

            $table->foreign('id_tipo_orden')
                ->references('id')
                ->on('ControlPresupuesto.tipos_ordenes');

            $table->foreign('id_tarjeta')
                ->references('id')
                ->on('ControlPresupuesto.tarjeta');

            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('dbo.conceptos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.solicitud_cambio_partidas');
    }
}
