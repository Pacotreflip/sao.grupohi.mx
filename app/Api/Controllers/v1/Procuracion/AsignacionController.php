<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 11:18
 */

namespace Ghi\Api\Controllers\v1\Procuracion;

use Ghi\Domain\Core\Contracts\Procuracion\AsignacionRepository;
use Ghi\Domain\Core\Transformers\AsignacionTransformer;
use Ghi\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;


/**
 * Class AsignacionController
 * @package Ghi\Api\Controllers\v1\Procuracion
 */
class AsignacionController extends Controller
{
    use Helpers;
    /**
     * @var AsignacionRepository
     */
    private $asignacionRepository;

    /**
     * ItemController constructor.
     * @param AsignacionRepository $asignacionRepository
     */
    public function __construct(AsignacionRepository $asignacionRepository)
    {
        $this->asignacionRepository = $asignacionRepository;
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $asignacionId = $this->asignacionRepository->create($request);
        $asignacion = $this->asignacionRepository->find($asignacionId);
        return $this->response->item($asignacion, new AsignacionTransformer($asignacion));
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->asignacionRepository->delete($id);
        return $this->response->accepted(null, 'success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        $items = $this->asignacionRepository->paginate($request->all());
        return response()->json([
            'recordsTotal' => $items->total(),
            'recordsFiltered' => $items->total(),
            'data' => $items->items()
        ], 200);
    }
}