<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntTiposCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('int_tipos_cuentas_contables', function (Blueprint $table) {
            $table->increments('id_tipo_cuenta_contable');
            $table->string('descripcion',254);
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
        Schema::drop('int_tipos_cuentas_contables');
    }
}
