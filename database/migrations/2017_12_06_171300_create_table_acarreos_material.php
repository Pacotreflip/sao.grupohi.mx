<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAcarreosMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Acarreos.material', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_material_acarreo");
            $table->integer('id_concepto');
            $table->integer('id_concepto_contrato');
            $table->integer('id_transaccion');
            $table->integer('id_item')->nullable();
            $table->float('tarifa');
            $table->string('registro');
            $table->timestamp('fechaHoraRegistro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Acarreos.material');
    }
}
