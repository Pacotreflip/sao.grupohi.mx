<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumeroFolioToTraspasoCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tesoreria.traspaso_cuentas', function (Blueprint $table) {
            $table->integer("id_obra")->unsigned();
            $table->integer("numero_folio")->unsigned();
            $table->date("fecha");
        });

        $table->foreign('id_obra')
            ->references('id_obra')
            ->on('dbo.obras')
            ->onDelete('no action');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tesoreria.traspaso_cuentas', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('numero_folio');
            $table->dropColumn('id_obra');
        });
    }
}
