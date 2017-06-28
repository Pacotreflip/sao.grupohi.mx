<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCuentasConceptos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_conceptos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_concepto")->unsigned();
            $table->string("cuenta",254);
            $table->integer("registro");
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('conceptos')
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
        Schema::drop('Contabilidad.cuentas_conceptos');
    }
}
