<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableControlPresupuestoTipoCobrabilidad extends Migration
{
    /**
     **
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.tipo_cobrabilidad', function (Blueprint $table) {
            $table->integer('id');
            $table->primary('id');
            $table->string("descripcion")->unique();
            $table->integer('estatus');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.tipo_cobrabilidad');
    }
}
