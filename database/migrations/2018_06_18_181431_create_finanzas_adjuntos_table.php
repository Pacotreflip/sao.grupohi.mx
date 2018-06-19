<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Finanzas.adjuntos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_adjunto');
            $table->integer('id_transaccion');
            $table->integer('id_usuario');
            $table->text('nombre');
            $table->string("extension", 15);
            $table->text("ruta");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cadeco')->drop('Finanzas.adjuntos');
    }
}
