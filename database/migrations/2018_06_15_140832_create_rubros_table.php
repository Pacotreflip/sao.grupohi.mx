<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Finanzas.rubros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo');
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
        Schema::connection('cadeco')->drop('Finanzas.rubros');
    }
}
