<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCuentasEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_obra")->unsigned();
            $table->integer("id_empresa")->unsigned();
            $table->integer("id_tipo_cuenta_empresa")->unsigned();
            $table->string("cuenta",254);
            $table->integer("registro");
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('obras')
                ->onDelete('cascade');
            
            $table->foreign('id_empresa')
                ->references('id_empresa')
                ->on('empresas')
                ->onDelete('cascade');
            
            $table->foreign('id_tipo_cuenta_empresa')
                ->references('id')
                ->on('contabilidad.tipos_cuentas_empresas')
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
        Schema::drop('Contabilidad.cuentas_empresas');
    }
}
