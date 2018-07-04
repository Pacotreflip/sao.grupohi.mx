<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:29 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;


use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Finanzas\SolicitudRecursosRepository;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class SolicitudRecursosController extends Controller
{
    use Helpers;

    protected $solicitudRecursosRepository;

    public function __construct(SolicitudRecursosRepository $solicitudRecursosRepository)
    {
        $this->middleware('api.permission:registrar_solicitud_recursos', ['only' => ['store']]);
        $this->solicitudRecursosRepository = $solicitudRecursosRepository;
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store() {
        $solicitud = $this->solicitudRecursosRepository->create();
        return response()->json($solicitud, 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){

        $resp = $this->solicitudRecursosRepository->paginate($request->all());

        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }

    public function syncPartidas(Request $request) {

    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function getSolicitudSemana()
    {
        $hoy = Carbon::now();
        $solicitud = SolicitudRecursos::where('semana', '=', $hoy->weekOfYear)->where('anio', '=', $hoy->year)->orderBy('id', 'DESC')->first();

        if($solicitud){
            return response()->json($solicitud, 200);
        } else {
            return $this->response->noContent();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     */
    public function finalizar(Request $request, $id) {
        try {
            $solicitud = $this->solicitudRecursosRepository->finalizar($id);
            return $this->response->item($solicitud, function ($item) {
                return $item;
            });
        } catch (\Exception $e) {
            throw new UpdateResourceFailedException($e->getMessage());
        }
    }
}