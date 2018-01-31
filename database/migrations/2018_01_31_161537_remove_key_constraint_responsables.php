<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveKeyConstraintResponsables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE [PresupuestoObra].[responsables] DROP CONSTRAINT [IX_responsables]');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE [PresupuestoObra].[responsables] ADD CONSTRAINT IX_responsables unique (id_responsable);');
    }
}
