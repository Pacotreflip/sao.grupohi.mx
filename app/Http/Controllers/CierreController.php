<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\CierreRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;
use Illuminate\View\View;

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
     * @return View
     */
    public function index() {
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

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store(Request $request) {
        $cierre = $this->cierre->create($request->all());
        return $this->response()->item($cierre, function ($item) { return $item; });
    }

    /**
     * @param $cierre
     * @return \Dingo\Api\Http\Response
     */
    public function show($cierre) {
        $cierre = $this->cierre->find($cierre);
        return $this->response()->item($cierre, function ($item) { return $item; });
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function open(Request $request, $id) {
        $cierre = $this->cierre->open($request->all(), $id);

        return $this->response()->item($cierre, function ($item) { return $item; });
    }

    /**
     * @param $cierre
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function close($cierre) {
        $cierre = $this->cierre->close($cierre);
        return $this->response()->item($cierre, function ($item) { return $item; });
    }
}
