<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasAlmacenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_almacenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_almacen")->unsigned();
            $table->string("cuenta",254);
            $table->integer("registro");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_almacen')
                ->references('id_almacen')
                ->on('almacenes')
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
        Schema::drop('Contabilidad.cuentas_almacenes');
    }
}
