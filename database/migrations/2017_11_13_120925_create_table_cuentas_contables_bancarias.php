<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCuentasContablesBancarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_contables_bancarias', function (Blueprint $table) {
            $table->increments('id_cuenta_contable_bancaria');
            $table->unsignedInteger("id_cuenta")->nullable();
            $table->unsignedInteger("id_tipo_cuenta_contable")->nullable();
            $table->string("cuenta",254);
            $table->unsignedInteger("estatus")->nullable();
            $table->unsignedInteger("registro")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_cuenta')
                ->references('id_cuenta')
                ->on('dbo.cuentas')
                ->onDelete('no action');

            $table->foreign('id_tipo_cuenta_contable')
                ->references('id_tipo_cuenta_contable')
                ->on('Contabilidad.int_tipos_cuentas_contables')
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
        Schema::drop('Contabilidad.cuentas_contables_bancarias');
    }
}
