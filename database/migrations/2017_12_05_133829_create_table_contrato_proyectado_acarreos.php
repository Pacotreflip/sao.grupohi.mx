<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContratoProyectadoAcarreos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Acarreos.contrato_proyectado', function (Blueprint $table) {
            $table->increments('id_contrato');
            $table->integer("id_transaccion");
            $table->string('descripcion');
            $table->integer('estatus')->default(1);
            $table->string('registro');
            $table->timestamp('fechaHoraRegistro');

            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Acarreos.contrato_proyectado');
    }
}
