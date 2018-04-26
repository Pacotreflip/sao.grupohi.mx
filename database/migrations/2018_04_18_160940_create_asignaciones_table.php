<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Procuracion.asignaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("id_transaccion");
            $table->integer("id_usuario_asigna");
            $table->integer("id_usuario_asignado");
            $table->integer("numero_folio");
            $table->index("id_usuario_asigna",'idx_usuario_asigna');
            $table->index("id_usuario_asignado",'idx_usuario_asignado');
            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('Procuracion.asignaciones');
    }
}
