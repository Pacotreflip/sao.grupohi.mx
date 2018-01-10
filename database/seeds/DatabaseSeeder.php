<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatosContablesObraSeeder::class);
        $this->call(EstatusControlCostos::class);
        $this->call(EstatusPrepolizasSeeder::class);
        $this->call(IntTiposPolizasContpaqSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        $this->call(RolePermissionsComprobanteFondoFijoSeeder::class);
        $this->call(PermisoCuentasContablesBancarias::class);
        $this->call(PermisoCuentasCostos::class);
        $this->call(PermisosCuentasFondos::class);
        $this->call(PermisoCuentasCostosAsignacion::class);
        $this->call(PermisosCuentasFondosAsignacion::class);
        $this->call(PermisosMovimientosBancarios::class);
        $this->call(PermisosTraspasoCuentas::class);
        $this->call(TesoreriaTiposMovimientos::class);
        $this->call(TiposCuentasGeneralesSeeder::class);
        $this->call(TiposCuentasSeeder::class);
        $this->call(TiposPolizasContpaqSeeder::class);
        $this->call(TiposMovimientosSeeder::class);
        $this->call(TiposCuentasEmpresasSeeder::class);
        $this->call(TiposCuentasMaterialSeeder::class);
        $this->call(TransaccionesInterfazSeeder::class);
        $this->call(NaturalezaPolizaTableSeeder::class);
        $this->call(PolizaTipoSAOSeeder::class);
        $this->call(TransaccionesSeeder::class);
        $this->call(ControlCostosSeeder::class);
        $this->call(IntTiposCuentasContablesSeeder::class);
        
    }
}
