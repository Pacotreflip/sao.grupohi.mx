<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddVigenciaToPolizaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->timestamp('inicio_vigencia')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fin_vigencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad.poliza_tipo', function (Blueprint $table) {
            $table->dropColumn(['inicio_vigencia', 'fin_vigencia']);
        });
    }
}
