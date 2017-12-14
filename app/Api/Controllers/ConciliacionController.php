<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:48 PM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ConciliacionRepository;
use Ghi\Domain\Core\Models\Costo;
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
        $this->conciliacion->store($request);
    }

    public function getCostos(){
        $costos = Costo::select(['id_costo', 'descripcion'])->get()->toArray();
        dd($costos);
    }
}