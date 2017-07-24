<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadPolizasItemsOrigen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.polizas_items_origen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_poliza');
            $table->unsignedInteger('id_item');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_poliza')
                ->references('id_int_poliza')
                ->on('Contabilidad.int_polizas');
            
            $table->foreign('id_item')
                ->references('id_item')
                ->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.polizas_items_origen');
    }
}
