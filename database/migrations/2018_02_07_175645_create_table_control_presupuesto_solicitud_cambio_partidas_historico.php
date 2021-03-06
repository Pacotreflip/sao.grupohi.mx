<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableControlPresupuestoSolicitudCambioPartidasHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.solicitud_cambio_partidas_historico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("id_solicitud_cambio_partida")->nullable();
            $table->unsignedInteger('id_base_presupuesto');
            $table->text('nivel');
            $table->float('cantidad_presupuestada_original')->nullable();
            $table->float('cantidad_presupuestada_actualizada')->nullable();
            $table->float('monto_presupuestado_original');
            $table->float('monto_presupuestado_actualizado');
            $table->timestamps();
            $table->float("precio_unitario_original")->nullable();
            $table->float("precio_unitario_actualizado")->nullable();
            $table->unsignedInteger('id_partidas_insumos_agrupados')->nullable();

            $table->foreign('id_partidas_insumos_agrupados')
                ->references('id')
                ->on('ControlPresupuesto.partidas_insumos_agrupados');

            $table->foreign('id_solicitud_cambio_partida')
                ->references('id')
                ->on('ControlPresupuesto.solicitud_cambio_partidas');

            $table->foreign('id_base_presupuesto')
                ->references('id')
                ->on('ControlPresupuesto.bases_presupuesto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.solicitud_cambio_partidas_historico');
    }
}
