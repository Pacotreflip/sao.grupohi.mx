<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdTipoCuentaContableToContabilidadTiposCuentasEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contabilidad.tipos_cuentas_empresas', function (Blueprint $table) {
            $table->integer('id_tipo_cuenta_contable')->unsigned()->nullable();

            $table->foreign('id_tipo_cuenta_contable')
                ->references('id_tipo_cuenta_contable')
                ->on('Contabilidad.int_tipos_cuentas_contables')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contabilidad.tipos_cuentas_empresas', function (Blueprint $table) {
            $table->dropForeign('contabilidad_tipos_cuentas_empresas_id_tipo_cuenta_contable_foreign');
            $table->dropColumn('id_tipo_cuenta_contable');
        });
    }
}
