<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlCostosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ControlCostos.solicitar_reclasificacion', function (Blueprint $table) {
            $table->increments('id_solicitar_reclasificacion');
            $table->unsignedInteger("id_concepto")->nullable();
            $table->unsignedInteger("id_concepto_nuevo")->nullable();
            $table->unsignedInteger("estatus")->nullable();
            $table->unsignedInteger("registro")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_concepto')
                ->references('id_concepto')
                ->on('dbo.conceptos')
                ->onDelete('no action');

            $table->foreign('id_concepto_nuevo')
                ->references('id_concepto')
                ->on('dbo.conceptos')
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
        Schema::drop('ControlCostos.solicitar_reclasificacion');
    }
}
