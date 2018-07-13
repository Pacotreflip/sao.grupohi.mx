<?php

use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::connection('seguridad')->statement('CREATE SCHEMA Configuracion AUTHORIZATION dbo;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::connection('seguridad')->statement('DROP SCHEMA Configuracion;');
    }
}