<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 25/07/2017
 * Time: 07:11 PM
 */

namespace Ghi\Http\Middleware;


use Closure;
use Illuminate\Http\Exception\HttpResponseException;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpFoundation\Response;

class EntrustPermission extends \Zizaco\Entrust\Middleware\EntrustPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {

        if ($this->auth->guest() || !$request->user()->can(explode('|', $permissions))) {
            if($request->ajax()) {
                throw new HttpResponseException(new Response('¡LO SENTIMOS, NO CUENTAS CON LOS PERMISOS NECESARIOS PARA REALIZAR LA OPERACIÓN SELECCIONADA!', 404));
            }
            Flash::error('¡LO SENTIMOS, NO CUENTAS CON LOS PERMISOS NECESARIOS PARA REALIZAR LA OPERACIÓN SELECCIONADA!');

            return redirect()->back();
        }

        return $next($request);
    }
}