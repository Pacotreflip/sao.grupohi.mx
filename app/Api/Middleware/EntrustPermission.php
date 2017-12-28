<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 25/07/2017
 * Time: 07:11 PM
 */

namespace Ghi\Api\Middleware;


use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
            throw new AccessDeniedHttpException('No cuentas con los permisos necesarios para realizar la operación solicitada');
        }
        return $next($request);
    }
}