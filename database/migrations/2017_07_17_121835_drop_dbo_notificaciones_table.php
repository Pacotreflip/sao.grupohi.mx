<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDboNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('dbo.notificaciones');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('dbo.notificaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 255);
            $table->integer('id_usuario');
            $table->integer('id_obra');
            $table->boolean('leida')->default(false);
            $table->integer('estatus');
            $table->timestamps();
            $table->softDeletes();

        });
    }
}
