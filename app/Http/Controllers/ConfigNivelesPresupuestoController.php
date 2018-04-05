<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\ConfigNivelesPresupuestoRepository;
use Ghi\Domain\Core\Models\ConceptoPath;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

/**
 * Class ConfigNivelesPresupuestoController
 * @package Ghi\Http\Controllers
 */
class ConfigNivelesPresupuestoController extends Controller
{
    use Helpers;
    /**
     * @var ConfigNivelesPresupuestoRepository
     */
    protected $configNivelesPresupuestoRepository;

    /**
     * PresupuestoController constructor.
     * @param ConfigNivelesPresupuestoRepository $configNivelesPresupuestoRepository
     */
    public function __construct(ConfigNivelesPresupuestoRepository $configNivelesPresupuestoRepository)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:administrar_roles_permisos', ['only' => ['store', 'update']]);

        $this->configNivelesPresupuestoRepository = $configNivelesPresupuestoRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function paginate(Request $request){
        $resp = $this->configNivelesPresupuestoRepository->paginate($request->all());
        if (count($resp) == 0) {
            $columns = ConceptoPath::getColumnsAttribute();
            if (count($columns)) {
                foreach ($columns as $column) {
                    $save = $this->configNivelesPresupuestoRepository->create((array)$column);
                    if (!$save) {
                        return response()->json($resp, 404);
                    }
                }
                $resp = $this->configNivelesPresupuestoRepository->paginate($request->all());
            }
        }
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }

    public function show($id)
    {
        $configNivel = $this->configNivelesPresupuestoRepository->find($id)->toArray();
        return response()->json([
            $configNivel,
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $configNivel = $this->configNivelesPresupuestoRepository->update($request->all(), $id);
        if(!$configNivel){
            return response()->json($id, 404);
        }
        return response()->json(['data' => $configNivel
        ], 200);
    }


    public function lists(Request $request){
        $resp = $this->configNivelesPresupuestoRepository->all()->toArray();
        if (count($resp) == 0) {
            $columns = ConceptoPath::getColumnsAttribute();
            if (count($columns)) {
                foreach ($columns as $column) {
                    $save = $this->configNivelesPresupuestoRepository->create((array)$column);
                    if (!$save) {
                        return response()->json($resp, 404);
                    }
                }
                $resp = $this->configNivelesPresupuestoRepository->all()->toArray();
            }
        }
        return response()->json(['data' => $resp], 200);
    }
}
