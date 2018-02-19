<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\UnidadRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class UnidadController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $unidad;

    public function __construct(UnidadRepository $unidad)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->unidad = $unidad;

    }
    public function getUnidadesByDescripcion(Request $request)
    {
        $items = $this->unidad->getUnidadesByDescripcion($request->descripcion);

        return $this->response->collection($items,function ($item){
            return $item;
        });

    }

}
