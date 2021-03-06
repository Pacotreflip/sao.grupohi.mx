<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 11:18
 */

namespace Ghi\Api\Controllers\v1\Procuracion;

use Dingo\Api\Routing\Helpers;
use Ghi\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\Procuracion\AsignacionesRepository;
use Ghi\Domain\Core\Transformers\AsignacionTransformer;
use Illuminate\Support\Facades\Log;


/**
 * Class AsignacionController
 * @package Ghi\Api\Controllers\v1\Procuracion
 */
class AsignacionController extends Controller
{
    use Helpers;
    /**
     * @var AsignacionesRepository
     */
    private $asignacionRepository;

    /**
     * AsignacionController constructor.
     * @param AsignacionesRepository $asignacionRepository
     */
    public function __construct(AsignacionesRepository $asignacionRepository)
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
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function maxivas(Request $request)
    {
        if ($request->has('asignaciones')) {
            $asignaciones = $request->get('asignaciones');
            if(is_array($asignaciones)) {
                $collection = collect($asignaciones);
                $asignaciones = $collection->unique(
                    function ($item) {
                        return $item['id_transaccion'].$item['id_usuario_asignado'];
                    })->values()->all();
                $arrayAsignacionId['exists'] = [];
                foreach ($asignaciones as $arrayAsignaciones) {
                    $whereAsignacion = $this->asignacionRepository->exists($arrayAsignaciones);
                    if($whereAsignacion) {
                        $arrayAsignacionId['exists'][] = $whereAsignacion->toArray();
                    }else{
                        $this->asignacionRepository->refresh()->create($arrayAsignaciones);
                    }
                }
                return $this->response->array($arrayAsignacionId, function ($item) {
                      return $item;
                });
            }
        }
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
        $items = $this->asignacionRepository->with(['usuario_asigna','usuario_asignado','transaccion.tipotran','transaccion'])->paginate($request->all());
        return response()->json([
            'recordsTotal' => $items->total(),
            'recordsFiltered' => $items->total(),
            'data' => $items->items()
        ], 200);
    }
}