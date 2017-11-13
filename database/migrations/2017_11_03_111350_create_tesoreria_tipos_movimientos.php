<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTesoreriaTiposMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tesoreria.tipos_movimientos', function (Blueprint $table) {
            $table->increments('id_tipo_movimiento');
            $table->text("descripcion")->nullable();
            $table->unsignedInteger("naturaleza")->nullable();
            $table->unsignedInteger("estatus")->nullable();
            $table->unsignedInteger("registro")->nullable();
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
        Schema::drop('Tesoreria.tipos_movimientos');
    }
}
