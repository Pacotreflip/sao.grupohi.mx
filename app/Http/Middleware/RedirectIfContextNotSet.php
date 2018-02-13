<?php

namespace Ghi\Http\Middleware;

use Closure;
use Ghi\Core\Contracts\Context;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Redirect;

class RedirectIfContextNotSet
{
    /**
     * @var RedirectIfContextNotSet
     */
    private $context;

    /**
     * @var Flash
     */
    private $flash;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @param Context $context
     * @param Flash $flash
     * @param Repository $config
     */
    function __construct(Context $context, Flash $flash, Repository $config)
    {
        $this->context = $context;
        $this->flash = $flash;
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->context->notEstablished()) {

            // Setea el id y nombre de la base si están presentes en la url
            if (in_array('DATABASE_NAME', array_keys($request->all())) && in_array('ID_OBRA', array_keys($request->all())))
            {
                $this->context->setId(base64_decode($request->ID_OBRA));
                $this->context->setDatabaseName(base64_decode($request->DATABASE_NAME));
            }

            else
            {
                Flash::error('¡Lo sentimos, debe seleccionar una obra para ver esta información!');
                return redirect()->guest(route('obras'));
            }
        }

        $this->setContext();

        return $next($request);
    }

    /**
     * Sets the datbase connection's database name for the current context
     */
    private function setContext()
    {
        $this->config->set('database.connections.cadeco.database', $this->context->getDatabaseName());
    }
}
