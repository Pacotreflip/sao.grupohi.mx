<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasItemsExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Compras.items_ext', function (Blueprint $table) {
            $table->integer('id_item')->primary()->unsigned();
            $table->string('observaciones',1000);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_item')
                ->references('id_item')
                ->on('items')
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
        Schema::drop('Compras.items_ext');
    }
}
