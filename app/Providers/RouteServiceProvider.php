<?php

namespace Ghi\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $web_namespace = 'Ghi\Http\Controllers';

    /**
     * This namespace is applied to your API controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $api_namespace = 'Ghi\Api\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        /*
        |--------------------------------------------------------------------------
        | Web Router
        |--------------------------------------------------------------------------
        */
        $router->group([
            'namespace' => $this->web_namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });

        /*
        |--------------------------------------------------------------------------
        | Api Router
        |--------------------------------------------------------------------------
        */
        $router->group([
            'namespace' => $this->api_namespace
        ], function ($router) {
            require app_path('Api/routes.php');
        });

    }
}
