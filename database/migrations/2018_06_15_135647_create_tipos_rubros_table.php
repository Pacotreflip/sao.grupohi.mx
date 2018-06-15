<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Finanzas.tipos_rubros', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descripcion", 50);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(["id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cadeco')->drop('Finanzas.tipos_rubros');
    }
}
