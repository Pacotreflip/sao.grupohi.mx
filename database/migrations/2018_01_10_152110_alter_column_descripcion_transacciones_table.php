<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnDescripcionTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('alter TABLE [dbo].[TipoTran]
                        alter column [Descripcion] [char](50) not null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('alter TABLE [dbo].[TipoTran]
                        alter column [Descripcion] [char](20) not null');
    }
}
