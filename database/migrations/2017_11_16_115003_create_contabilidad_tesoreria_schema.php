<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadTesoreriaSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('CREATE SCHEMA ContabilidadTesoreria AUTHORIZATION dbo;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP SCHEMA ContabilidadTesoreria;');
    }
}
