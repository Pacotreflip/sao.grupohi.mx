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
        Schema::create('sistemas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to sistemas (Many-to-Many)
        Schema::create('sistemas_permisos', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('sistemas_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sistemas_id')->references('id')->on('sistemas')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'sistemas_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistemas');
        Schema::drop('sistemas_permisos');
    }
}
