<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcarreosConciliacionEstimacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Acarreos.conciliacion_estimacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_conciliacion");
            $table->integer('id_estimacion');
            $table->string('registro');
            $table->timestamp('fechaHoraRegistro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Acarreos.conciliacion_estimacion');
    }
}
