<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasCtgTiposSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cadeco')->create('Finanzas.ctg_tipos_solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 50);
            $table->string('descripcion_corta', 5);
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
        Schema::connection('cadeco')->drop('Finanzas.ctg_tipos_solicitud');
    }
}
