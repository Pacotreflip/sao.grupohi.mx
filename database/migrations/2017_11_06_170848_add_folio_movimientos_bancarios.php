<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFolioMovimientosBancarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tesoreria.movimientos_bancarios', function (Blueprint $table) {
            $table->unsignedInteger("id_obra")->nullable();
            $table->unsignedInteger("numero_folio")->nullable();
            $table->date("fecha");

            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('dbo.obras')
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
        Schema::table('Tesoreria.movimientos_bancarios', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('numero_folio');
            $table->dropColumn('id_obra');
        });
    }
}
