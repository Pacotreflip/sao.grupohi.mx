<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\DatosContablesRepository;
use Illuminate\Http\Request;

class DatosContablesController extends Controller
{
    use Helpers;

    /**
     * @var DatosContablesRepository
     */
    private $datos_contables;

    /**
     * DatosContablesController constructor.
     * @param DatosContablesRepository $datos_contables
     */
    public function __construct(DatosContablesRepository $datos_contables)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:editar_configuracion_contable', ['only' => ['edit', 'update']]);

        $this->datos_contables = $datos_contables;
    }

    public function edit($id) {
        $datos_contables = $this->datos_contables->find($id);

        // Referencia para indicar si existen datos
        $referencia = isset($datos_contables->FormatoCuenta) ? "1" : "0";

        return view('sistema_contable.datos_contables.edit')
            ->with('datos_contables', $datos_contables)
            ->with('referencia', $referencia);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(Request $request) {
        $item = $this->datos_contables->findBy($request->attribute, $request->value);

        return response()->json(['data' => ['datos_contables' => $item]], 200);
    }

    public function update(Request $request, $id) {
        $item = $this->datos_contables->update($request->all(), $id);
        return response()->json(['data' => ['datos_contables' => $item]], 200);
    }
}
