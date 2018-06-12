<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 01/06/2018
 * Time: 17:03 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Finanzas\PagoCuentaRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;

/**
 * Class PagoCuentaController
 * @package Ghi\Api\Controllers\v1\Finanzas\PagoCuentaController
 */
class PagoCuentaController extends BaseController
{
    use Helpers;
    /**
     * @var PagoCuentaRepository
     */
    protected $pagoCuentaRepository;

    /**
     * TraspasoCuentasController constructor.
     *
     * @param PagoCuentaRepository $pagoCuentaRepository
     */
    public function __construct(PagoCuentaRepository $pagoCuentaRepository)
    {
        $this->middleware('api.permission:registrar_pago_cuenta', ['only' => ['store']]);
        $this->pagoCuentaRepository = $pagoCuentaRepository;

    }

    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        Validator::extend('uniqueid_antecedente', function($attribute, $value, $parameters, $validator) {
            $option = $this->pagoCuentaRepository->where([$attribute => $value])->get();
            if (count($option->toArray())) {
                return false;
            } else {
                return true;
            }
        });

        $rules = [
            'cumplimiento' => ['required', 'date'],
            'vencimiento' => ['required', 'date'],
            'fecha' => ['required', 'date', 'periodo_abierto'],
            'monto' => ['required', 'string',],
            'destino' => ['required', 'string',],
            'observaciones' => ['string',],
            'id_empresa' => ['required', 'exists:cadeco.empresas,id_empresa'],
            'id_costo' => ['required', 'exists:cadeco.costos,id_costo'],
            'id_antecedente' => ['required', 'uniqueid_antecedente', 'sin_facturas'],
        ];

        $messages = [
            'uniqueid_antecedente' => 'Ya existe una solicitud generada para la transacción seleccionada',
        ];

        $validator = app('validator')->make($request->all(), $rules, $messages);
        if (count($validator->errors()->all())) {
            throw new ValidationHttpException($validator->errors());
        } else {
            $this->pagoCuentaRepository->create($request->all());
            return $this->response()->created();
        }
    }

    public function getTiposTran() {
        return response()->json($this->pagoCuentaRepository->getTiposTran());
    }
}