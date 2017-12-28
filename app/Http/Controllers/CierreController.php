<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Seguridad\CierreRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class CierreController extends Controller
{

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
}
