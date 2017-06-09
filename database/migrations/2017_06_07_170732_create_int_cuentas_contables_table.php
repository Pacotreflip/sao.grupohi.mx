<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntCuentasContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('int_cuentas_contables', function (Blueprint $table) {
            $table->increments('id_int_cuenta_contable');
            $table->unsignedInteger('id_obra')->index();
            $table->unsignedInteger('id_int_tipo_cuenta_contable')->index();
            $table->string('prefijo',50)->nullable();
            $table->string('sufijo',50)->nullable();
            $table->string('cuenta_contable',50)->nullable();
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
        Schema::drop('int_cuentas_contables');

    }
}
