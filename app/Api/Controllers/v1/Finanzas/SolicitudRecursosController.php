<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:29 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;


use Carbon\Carbon;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Finanzas\SolicitudRecursosRepository;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class SolicitudRecursosController extends Controller
{
    use Helpers;

    protected $solicitudRecursosRepository;

    public function __construct(SolicitudRecursosRepository $solicitudRecursosRepository)
    {
        $this->middleware('api.permission:registrar_solicitud_recursos', ['only' => ['store']]);
        //Métodos de consulta
        $this->middleware('api.permission:consultar_solicitud_recursos', ['only' => ['paginate', 'getSolicitudSemana','show']]);
        //Métodos de edición/modificación
        $this->middleware('api.permission:modificar_solicitud_recursos', ['only' => ['agregarPartida']]);
        //Método de elimiación
        $this->middleware('api.permission:eliminar_solicitud_recursos', ['only' => ['removerPartida']]);
        //Método de finalizar
        $this->middleware('api.permission:finalizar_solicitud_recursos', ['only' => ['finalizar']]);

        $this->solicitudRecursosRepository = $solicitudRecursosRepository;
    }

    /**
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
     * @return \Dingo\Api\Http\Response
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

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function agregarPartida(Request $request, $id) {
        $rules = [
            'id_transaccion' => ['required'],
        ];

        $validator = app('validator')->make($request->all(), $rules);

        try {
            if (count($validator->errors()->all())) {
                throw new StoreResourceFailedException('Error al agregar la partida', $validator->errors());
            } else {
                $this->solicitudRecursosRepository->addPartida($id, $request->id_transaccion);
                //Obtener la solicitud para mostrar el mensaje de la actualización
                $data_solicitud = $this->solicitudRecursosRepository->find($id);
                return response()->json([
                    'solicitud' => $data_solicitud->folio]
                    , 200);
            }
        } catch (\Exception $e) {
            throw new StoreResourceFailedException($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function removerPartida(Request $request, $id) {
        $rules = [
            'id_transaccion' => ['required'],
        ];

        $validator = app('validator')->make($request->all(), $rules);

        try {
            if (count($validator->errors()->all())) {
                throw new DeleteResourceFailedException('Error al remover la partida', $validator->errors());
            } else {
                $this->solicitudRecursosRepository->removePartida($id, $request->id_transaccion);
                //Obtener la solicitud para mostrar el mensaje de la actualización
                $data_solicitud = $this->solicitudRecursosRepository->find($id);
                return response()->json([
                        'solicitud' => $data_solicitud->folio]
                    , 200);
            }
        } catch (\Exception $e) {
            throw new DeleteResourceFailedException($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request, $id) {
        try {
            $solicitud = $this->solicitudRecursosRepository->with($request->with)->find($id);

            return response()->json($solicitud, 200);

        } catch (\Exception $e) {
            throw new ResourceNotFoundException($e->getMessage());
        }
    }
}