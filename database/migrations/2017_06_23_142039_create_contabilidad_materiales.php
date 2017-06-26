<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Contabilidad.cuentas_materiales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_obra")->unsigned();
            $table->integer("id_material")->unsigned();
            $table->integer("id_tipo_cuenta_material")->unsigned();
            $table->string("cuenta",254);
            $table->integer("registro");
            $table->softDeletes();
            
            $table->foreign('id_obra')
                ->references('id_obra')
                ->on('obras')
                ->onDelete('cascade');
            
            $table->foreign('id_material')
                ->references('id_material')
                ->on('materiales')
                ->onDelete('cascade');
            
            $table->foreign('id_tipo_cuenta_material')
                ->references('id')
                ->on('contabilidad.tipos_cuentas_materiales')
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
        Schema::drop('Contabilidad.cuentas_materiales');
    }
}
