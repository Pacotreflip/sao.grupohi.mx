<?php

namespace Ghi\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', \Ghi\Http\Composers\ObraComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Ghi\Core\Contracts\Context::class,
            \Ghi\Core\App\ContextSession::class
        );

        $this->app->singleton('ghi.context', \Ghi\Core\App\ContextSession::class);


        $this->app->bind(
            \Ghi\Domain\Core\Contracts\UserRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentUserRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentPolizaTipoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\MovimientoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentMovimientoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\TipoMovimientoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentTipoMovimientoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAORepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentPolizaTipoSAORepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ObraRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentObraRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaContableRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentTipoCuentaContableRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentPolizaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\PolizaHistoricoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentPolizaHistoricoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\DatosContablesRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentDatosContablesRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentConceptoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaEmpresaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaAlmacenRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaAlmacenRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\AlmacenRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentAlmacenRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\EmpresaRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentEmpresaRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaEmpresaRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentTipoCuentaEmpresaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaConceptoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaConceptoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ItemRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentItemRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Compras\RequisicionRepository::class,
            \Ghi\Domain\Core\Repositories\Compras\EloquentRequisicionRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\MaterialRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentMaterialRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Compras\DepartamentoResponsableRepository::class,
            \Ghi\Domain\Core\Repositories\Compras\EloquentDepartamentoResponsableRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Compras\TipoRequisicionRepository::class,
            \Ghi\Domain\Core\Repositories\Compras\EloquentTipoRequisicionRepository::class
        );


        $this->app->bind(
            \Ghi\Domain\Core\Contracts\MaterialRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentMaterialRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ItemsRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentItemsRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaMaterialRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaMaterialRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentNotificacionRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\TransaccionesInterfazRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentTransaccionesInterfazRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimientoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentPolizaMovimientoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaMaterialRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentTipoCuentaMaterialRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\GraficasRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentGraficasRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\RevaluacionRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentRevaluacionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentDiaFestivoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\FacturaRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentFacturaRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaFondoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaFondoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\FondoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentFondoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Finanzas\ComprobanteFondoFijoRepository::class,
            \Ghi\Domain\Core\Repositories\Finanzas\EloquentComprobanteFondoFijoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\EstimacionRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentEstimacionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\SubcontratoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentSubcontratoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository::class,
            \Ghi\Domain\Core\Repositories\Tesoreria\EloquentTraspasoCuentasRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Tesoreria\TraspasoTransaccionRepository::class,
            \Ghi\Domain\Core\Repositories\Tesoreria\EloquentTraspasoTransaccionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository::class,
            \Ghi\Domain\Core\Repositories\Tesoreria\EloquentMovimientosBancariosRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaBancosRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaBancosRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CuentaCostoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCuentaCostoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CostoRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCostoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository::class,
            \Ghi\Domain\Core\Repositories\ControlCostos\EloquentSolicitudReclasificacionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository::class,
            \Ghi\Domain\Core\Repositories\ControlCostos\EloquentSolicitudReclasificacionPartidasRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionAutorizadaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlCostos\EloquentSolicitudReclasificacionAutorizadaRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRechazadaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlCostos\EloquentSolicitudReclasificacionRechazadaRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentConceptoPathRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentPresupuestoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\TransaccionRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentTransaccionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\SucursalRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentSucursalRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ContratoProyectadoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ContratoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentContratoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ConciliacionRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentConciliacionRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CierreRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCierreRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\TipoTranRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentTipoTranRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\MovimientosRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentMovimientosRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\PermissionRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentPermissionRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\RoleRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentRoleRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentBasePresupuestoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoCobrabilidadRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentTipoCobrabilidadRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoOrdenRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentTipoOrdenRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\EstatusRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentEstatusRepository::class
        );


        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentSolicitudCambioRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\VariacionVolumenRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentVariacionVolumenRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\EscalatoriaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentEscalatoriaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentCambioInsumosRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentSolicitudCambioPartidaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioAutorizadaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentSolicitudCambioAutorizadaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRechazadaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentSolicitudCambioRechazadaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentTarjetaRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Contabilidad\CostosDolaresRepository::class,
            \Ghi\Domain\Core\Repositories\Contabilidad\EloquentCostosDolaresRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentAfectacionOrdenPresupuestoRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentPartidasInsumosAgrupadosRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\UnidadRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentUnidadRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoFiltroRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentTipoFiltroRepository::class
        );
        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioCantidadInsumosRepository::class,
            \Ghi\Domain\Core\Repositories\ControlPresupuesto\EloquentCambioCantidadInsumosRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\ConfigNivelesPresupuestoRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentConfigNivelesPresupuestoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\ConfiguracionObraRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentConfiguracionObraRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Seguridad\AccesosApiRepository::class,
            \Ghi\Domain\Core\Repositories\Seguridad\EloquentAccesosApiRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Procuracion\AsignacionesRepository::class,
            \Ghi\Domain\Core\Repositories\Programacion\EloquentAsignacionesRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Subcontratos\AsignacionesRepository::class,
            \Ghi\Domain\Core\Repositories\Subcontratos\EloquentAsignacionesRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Subcontratos\PartidaAsignacionRepository::class,
            \Ghi\Domain\Core\Repositories\Subcontratos\EloquentPartidaAsignacionRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Finanzas\ReposicionFondoFijoRepository::class,
            \Ghi\Domain\Core\Repositories\Finanzas\EloquentReposicionFondoFijoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\Finanzas\PagoCuentaRepository::class,
            \Ghi\Domain\Core\Repositories\Finanzas\EloquentPagoCuentaRepository::class
        );
    }
}
