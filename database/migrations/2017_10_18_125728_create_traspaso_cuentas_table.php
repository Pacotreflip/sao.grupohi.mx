<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraspasoCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.traspaso_cuentas', function (Blueprint $table) {
            $table->increments('id_traspaso');
            $table->integer("estatus");
            $table->integer("id_cuenta_origen")->unsigned();
            $table->integer("id_cuenta_destino")->unsigned();
            $table->float("importe");
            $table->text("observaciones");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_cuenta_origen')
                ->references('id_cuenta')
                ->on('dbo.cuentas')
                ->onDelete('no action');

            $table->foreign('id_cuenta_destino')
                ->references('id_cuenta')
                ->on('dbo.cuentas')
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
        Schema::drop('Contabilidad.traspaso_cuentas');
    }
}
