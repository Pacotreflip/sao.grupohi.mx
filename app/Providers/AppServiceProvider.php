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
            \Ghi\Domain\Core\Contracts\PolizaTipoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentPolizaTipoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\MovimientoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentMovimientoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\TipoMovimientoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentTipoMovimientoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\TransaccionInterfazRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentTransaccionInterfazRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\ObraRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentObraRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\CuentaContableRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentCuentaContableRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\TipoCuentaContableRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentTipoCuentaContableRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\PolizaRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentPolizaRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\PolizaHistoricoRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentPolizaHistoricoRepository::class
        );

        $this->app->bind(
            \Ghi\Domain\Core\Contracts\DatosContablesRepository::class,
            \Ghi\Domain\Core\Repositories\EloquentDatosContablesRepository::class
        );
    }
}
