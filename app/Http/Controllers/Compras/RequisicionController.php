<?php

namespace Ghi\Http\Controllers\Compras;

use Dingo\Api\Routing\Helpers;

use Ghi\Domain\Core\Contracts\Compras\DepartamentoResponsableRepository;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\Compras\TipoRequisicionRepository;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Illuminate\Http\Request;
use Ghi\Http\Controllers\Controller;

class RequisicionController extends Controller
{
    use Helpers;

    protected $requisicion;
    protected $material;
    protected $departamento_responsable;
    protected $tipo_requisicion;

    /**
     * RequisicionController constructor.
     * @param RequisicionRepository $requisicion
     * @param MaterialRepository $material
     * @param DepartamentoResponsableRepository $departamento_responsable
     */
    public function __construct(
        RequisicionRepository $requisicion,
        MaterialRepository $material,
        DepartamentoResponsableRepository $departamento_responsable,
        TipoRequisicionRepository $tipo_requisicion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->requisicion = $requisicion;
        $this->material = $material;
        $this->departamento_responsable = $departamento_responsable;
        $this->tipo_requisicion= $tipo_requisicion;
    }

    public function index() {
        $items = $this->requisicion->all();

        return view('compras.requisicion.index')
            ->with('requisiciones', $items);
    }

    public function show($id) {
        $item = $this->requisicion->with('items')->find($id);

        return view('compras.requisicion.show')
            ->with('requisicion', $item);
    }

    public function create() {
        $departamentos_responsables = $this->departamento_responsable->all();
        $tipos_requisiciones = $this->tipo_requisicion->all();

        return view('compras.requisicion.create')
            ->with([
                'departamentos_responsables' => $departamentos_responsables,
                'tipos_requisiciones'          => $tipos_requisiciones
            ]);
    }

    public function edit($id) {
        $item = $this->requisicion->with(['items.material','items.itemExt','transaccionExt'])->find($id);
        $departamentos_responsables = $this->departamento_responsable->all();
        $tipos_requisiciones = $this->tipo_requisicion->all();

        $materiales = $this->material->scope('materiales')->getBy('unidad','!=', null);

        return view('compras.requisicion.edit')
            ->with([
                'requisicion' => $item,
                'materiales' => $materiales,
                'departamentos_responsables' => $departamentos_responsables,
                'tipos_requisiciones'          => $tipos_requisiciones
            ]);
    }

    public function update(Request $request, $id) {
        $item = $this->requisicion->update($request->all(), $id);

        return response()->json(['data' => ['requisicion' => $item]], 200);
    }

    public function store(Request $request) {
        $item = $this->requisicion->create($request->all());

        return response()->json(['data' => ['requisicion' => $item]],200);
    }

    public function destroy($id) {
        $this->requisicion->delete($id);
        return $this->response->accepted();
    }
}