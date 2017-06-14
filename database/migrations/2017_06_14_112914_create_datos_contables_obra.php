<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosContablesObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad.datos_contables_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_obra')->index();
            $table->string('BDContPaq')->nullable();
            $table->integer('NumobraContPaq')->nullable();
            $table->string('FormatoCuenta')->nullable();
            $table->string('FormatoCuentaRegExp')->nullable();
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
        Schema::drop('contabilidad.datos_contables_obra');

    }
}
