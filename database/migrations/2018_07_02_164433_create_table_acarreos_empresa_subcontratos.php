<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAcarreosEmpresaSubcontratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Acarreos.empresa_subcontratos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_empresa_sao");
            $table->integer('id_empresa_acarreo');
            $table->integer('id_sindicato_acarreo');
            $table->integer('id_tipo_tarifa');
            $table->integer('id_subcontrato');
            $table->string('registro');
            $table->timestamp('fechaHoraRegistro');

            $table->foreign('id_empresa_sao')
                ->references('id_empresa')
                ->on('dbo.empresas');

            $table->foreign('id_subcontrato')
                ->references('id_transaccion')
                ->on('dbo.transacciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Acarreos.empresa_subcontratos');
    }
}
