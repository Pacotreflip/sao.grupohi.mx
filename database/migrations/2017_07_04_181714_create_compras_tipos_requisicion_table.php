<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTiposRequisicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Compras.tipos_requisicion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('descripcion_corta');
            $table->integer('estatus')->default(1);
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
        Schema::drop('Compras.tipos_requisicion');
    }
}
