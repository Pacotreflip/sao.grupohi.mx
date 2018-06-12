<?php

namespace Ghi\Http\Middleware;

use Closure;
use Ghi\Domain\Core\Models\Seguridad\Sistema;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use \Entrust;
use Laracasts\Flash\Flash;

class SystemAccess
{

    private $session;
    /**
     * SystemAccess constructor.
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param $sistema
     * @return mixed
     */
    public function handle($request, Closure $next, $sistema)
    {
        $permisos = Sistema::where('url', '=', $sistema)->first()->permisos()->lists('name')->toArray();

        if (! Entrust::can($permisos)) {
            if($request->ajax()) {
                throw new HttpResponseException(new Response('¡LO SENTIMOS, NO CUENTAS CON LOS PERMISOS NECESARIOS PARA REALIZAR LA OPERACIÓN SELECCIONADA!', 403));
            }
            Flash::error('¡LO SENTIMOS, NO CUENTAS CON LOS PERMISOS NECESARIOS PARA REALIZAR LA OPERACIÓN SELECCIONADA!');
            return redirect()->back();
        }

        return $next($request);
    }
}