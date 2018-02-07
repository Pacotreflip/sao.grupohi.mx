<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPresupuestoConceptoEscalatoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlPresupuesto.concepto_escalatoria', function (Blueprint $table) {
            $table->integer('id_concepto')->unsigned();
            $table->integer('registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ControlPresupuesto.concepto_escalatoria');
    }
}
