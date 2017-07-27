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
    }
}
