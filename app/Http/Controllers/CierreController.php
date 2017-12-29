<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\CierreRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class CierreController extends Controller
{

    use Helpers;
    /**
     * @var CierreRepository
     */
    protected $cierre;

    /**
     * CierreController constructor.
     */
    public function __construct(CierreRepository $cierre)
    {
        $this->middleware(['auth', 'context']);

        $this->cierre = $cierre;
    }

    /**
     * @return Vie
     */
    public function index(Request $request) {
        return view('configuracion.cierre.index');
    }

    public function paginate(Request $request) {
        $cierres = $this->cierre->paginate($request->all());

        return response()->json([
            'recordsTotal' => $cierres->total(),
            'recordsFiltered' => $cierres->total(),
            'data' => $cierres->items()
        ], 200);
    }

    public function store(Request $request) {
        $cierre = $this->cierre->create($request->all());
        return $this->response->item($cierre, function ($item) {
            return $item;
        });
    }

    public function show(Request $request, $cierre) {
        $cierre = $this->cierre->find($cierre);

        return $this->response()->item($cierre, function ($item) {
            return $item;
        });
    }
}
