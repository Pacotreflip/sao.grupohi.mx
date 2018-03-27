<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConfiguracionObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('seguridad')->create('configuracion_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->binary('logotipo_original')->nullable();
            $table->binary('logotipo_reportes')->nullable();
            $table->integer('vigencia');
            $table->integer('id_user');
            $table->integer('id_proyecto')->unsigned();
            $table->integer('id_obra')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_proyecto')
                ->references('id')
                ->on('dbo.proyectos')
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
        Schema::drop('configuracion_obra');
    }
}
