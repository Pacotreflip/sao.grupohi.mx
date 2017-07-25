<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dbo.notificaciones_html', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',255);
            $table->string('idPolizas',300);
            $table->integer('total_polizas');
            $table->integer('id_usuario');
            $table->integer('id_obra');
            $table->integer('estatus');
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
        Schema::drop('dbo.notificaciones_html');
    }
}
