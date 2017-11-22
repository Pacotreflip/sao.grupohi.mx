<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CostoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaCostoRepository;
use Illuminate\Http\Request;

class CuentaCostoController extends Controller
{

    use Helpers;

    protected $costo;

    /**
     * CuentaCosto constructor.
     * @param CostoRepository|CuentaCostoRepository $costo
     * @param CuentaCostoRepository $cuenta_costo
     * @internal param costoRepository $costo
     */
    public function __construct(CostoRepository $costo, CuentaCostoRepository $cuenta_costo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_cuenta_costo', ['only' => ['index']]);
        $this->middleware('permission:registrar_cuenta_costo', ['only' => ['store']]);
        $this->middleware('permission:editar_cuenta_costo', ['only' => ['update']]);

        $this->costo = $costo;
        $this->cuenta_costo = $cuenta_costo;
    }

    public function index()
    {
        $costos = $this->costo->getBy('nivel', 'like', '___.', 'cuentaCosto');

        return view('sistema_contable.cuenta_costo.index')->with('costos', $costos);
    }

    public function update(Request $request, $id)
    {
        $item = $this->cuenta_costo->update($request->all(), $id);

        return response()->json(['data' => ['cuenta_costo' => $item]],200);
    }

    public function store(Request $request)
    {
        $item = $this->cuenta_costo->create($request->all());

        return response()->json(['data' => ['cuenta_costo' => $item]],200);
    }

    public function searchNodo(Request $request){

        if(strlen($request->all()['texto'])>0) {
            $costos = $this->costo->getBy('descripcion', 'like', '%' . $request->all()['texto'] . '%');
        }
        else{
            $costos = $this->costo->getBy('nivel', 'like', '___.', 'cuentacosto');

        }
        return response()->json(['data' => ['costo' => $costos]],200);
    }

    public function destroy($id)
    {
        $this->cuenta_costo->delete($id);

        return response()->json(['data' => ['cuenta_costo' => '']],200);
    }
}
