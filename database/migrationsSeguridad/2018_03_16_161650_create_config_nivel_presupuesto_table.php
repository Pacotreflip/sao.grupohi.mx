<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateConfigNivelPresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('seguridad')->create('config_niveles_presupuesto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_by');
            $table->string('name_column',50);
            $table->string('description',50)->nullable();
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
        Schema::connection('seguridad')->drop('config_niveles_presupuestos');
    }
}
