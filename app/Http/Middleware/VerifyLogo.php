<?php

namespace Ghi\Http\Middleware;

use Ghi\Api\Middleware;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Ghi\Core\Contracts\Context;
use Laracasts\Flash\Flash;
use Closure;
use Ghi\Domain\Core\Contracts\Seguridad\ConfiguracionObraRepository;

class VerifyLogo
{
    /**
     * @var Repository
     */
    private $configuracionObraRepository;

    /**
     * VerifyLogo constructor.
     * @param ConfiguracionObraRepository $configuracionObraRepository
     */
    function __construct(ConfiguracionObraRepository $configuracionObraRepository)
    {
        $this->configuracionObraRepository = $configuracionObraRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = $this->configuracionObraRepository->all()->toArray();
        if(!$config) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            Flash::error('¡Para poder ver el logo de la obra, debe configurarlo!');
            //return redirect()->guest(route('configuracion.obra.index'));
        }
        return $next($request);
    }
}
