<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:48 PM
 */

namespace Ghi\Api\Controllers\v1;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ConciliacionRepository;
use Ghi\Http\Controllers\Controller;
use Dingo\Api\Http\Request;


class ConciliacionController extends Controller
{
    use Helpers;

    private $conciliacion;

    /**
     * SubcontratoController constructor.
     * @param ConciliacionRepository $conciliacion
     */
    public function __construct(ConciliacionRepository $conciliacion)
    {
        $this->conciliacion = $conciliacion;
    }

    public function store(Request $request){
        $conciliacion = $this->conciliacion->store($request);
        return $conciliacion->toArray();
    }

    public function delete($id){
        $respuesta = $this->conciliacion->delete($id);
        return $respuesta;
    }

    public function getCostos(Request $request){
        return $this->conciliacion->getCostos($request);
    }
}