<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCuentasCostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_costos', function (Blueprint $table) {
            $table->increments('id_cuenta_costo');
            $table->unsignedInteger("id_costo")->nullable();
            $table->string("cuenta",254);
            $table->unsignedInteger("estatus")->nullable();
            $table->unsignedInteger("registro")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_costo')
                ->references('id_costo')
                ->on('dbo.costos')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Contabilidad.cuentas_costos');
    }
}
