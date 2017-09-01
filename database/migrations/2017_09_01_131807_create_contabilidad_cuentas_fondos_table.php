<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCuentasFondosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_fondos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_fondo")->unsigned();
            $table->string("cuenta",254);
            $table->integer("registro");
            $table->integer("estatus");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_fondo')
                ->references('id_fondo')
                ->on('dbo.fondos')
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
        Schema::drop('Contabilidad.cuentas_fondos');
    }
}
