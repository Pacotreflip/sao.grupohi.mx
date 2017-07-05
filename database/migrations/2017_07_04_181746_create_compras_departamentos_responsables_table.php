<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasDepartamentosResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Compras.departamentos_responsables', function (Blueprint $table) {
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
        Schema::drop('Compras.departamentos_responsables');
    }
}
