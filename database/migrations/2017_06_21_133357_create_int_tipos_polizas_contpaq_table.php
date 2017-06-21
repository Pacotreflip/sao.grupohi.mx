<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntTiposPolizasContpaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.int_tipos_polizas_contpaq', function (Blueprint $table) {
            $table->increments('id_int_tipo_poliza_contpaq');
            $table->string('descripcion',254);
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
        Schema::drop('contabilidad.int_tipos_polizas_contpaq');
    }
}
