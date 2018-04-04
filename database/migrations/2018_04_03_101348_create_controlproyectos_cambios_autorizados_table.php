<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlproyectosCambiosAutorizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlProyectos.cambios_autorizados', function (Blueprint $table) {
            $table->unsignedInteger('id_moneda');
            $table->float('cambio');

            $table->foreign('id_moneda')
                ->references('id_moneda')
                ->on('dbo.monedas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.cambios_autorizados');
    }
}
