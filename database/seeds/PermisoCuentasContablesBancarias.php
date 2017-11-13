<?php

use Illuminate\Database\Seeder;

class PermisoCuentasContablesBancarias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'eliminar_cuenta_contable_bancaria', 'display_name' => 'Eliminar Cuenta Contable Bancaria', 'description' => 'Permiso para eliminar cuentas contables bancarias']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'registrar_cuenta_contable_bancaria', 'display_name' => 'Registrar Cuenta Contable Bancaria', 'description' => 'Permiso para registrar cuentas contables bancarias']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'consultar_cuenta_contable_bancaria', 'display_name' => 'Consultar Cuenta Contable Bancaria', 'description' => 'Permiso para consultar cuentas contables bancarias']);
        \Ghi\Domain\Core\Models\Seguridad\Permission::create(['name' => 'editar_cuenta_contable_bancaria', 'display_name' => 'Editar Cuenta Contable Bancaria', 'description' => 'Permiso para editar cuentas contables bancarias']);
    }
}
