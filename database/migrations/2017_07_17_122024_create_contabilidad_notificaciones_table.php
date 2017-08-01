<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.notificaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',255);
            $table->integer('id_usuario');
            $table->integer('id_obra');
            $table->boolean('leida')->default(false);
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
        Schema::drop('Contabilidad.notificaciones');
    }
}
