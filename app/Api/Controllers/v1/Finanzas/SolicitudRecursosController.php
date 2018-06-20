<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:29 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;


use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Dotenv\Exception\ValidationException;
use Ghi\Domain\Core\Contracts\Finanzas\SolicitudRecursosRepository;
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


    public function store(Request $request) {

        $rules = [
            'id_tipo' => ['required', 'exists:cadeco.Finanzas.ctg_tipos_solicitud,id'],
            'partidas' => ['required', 'array'],
            'partidas.*.id_transaccion' => ['required', 'exists:cadeco.dbo.transacciones,id_transaccion']
        ];

        $validator = Validator::make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new ValidationException($validator->errors());
        } else {
            try {
                $this->solicitudRecursosRepository->create($request->all());
            } catch (\Exception $e) {

            }
            return $this->response()->created();
        }
    }
}