<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTransaccionesExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Compras.transacciones_ext', function (Blueprint $table) {
            $table->integer('id_transaccion')->primary()->unsigned();
            $table->string('folio_adicional');
            $table->integer('id_departamento')->unsigned();
            $table->integer('id_tipo_requisicion')->unsigned();
            $table->timestamps();
            $table->softDeletes();



            $table->foreign('id_departamento')
                ->references('id')
                ->on('Compras.departamentos_responsables')
                ->onDelete('cascade');

            $table->foreign('id_tipo_requisicion')
                ->references('id')
                ->on('Compras.tipos_requisicion')
                ->onDelete('cascade');

            $table->foreign('id_transaccion')
                ->references('id_transaccion')
                ->on('transacciones')
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
        Schema::drop('Compras.transacciones_ext');
    }
}
