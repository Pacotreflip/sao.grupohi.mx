<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing sistemas
        Schema::connection('seguridad')->create('sistemas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->string('url');
        });

        // Create table for associating permissions to sistemas (Many-to-Many)
        Schema::connection('seguridad')->create('sistemas_permisos', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('sistema_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sistema_id')->references('id')->on('sistemas')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'sistema_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('seguridad')->drop('sistemas');
        Schema::connection('seguridad')->drop('sistemas_permisos');
    }
}
