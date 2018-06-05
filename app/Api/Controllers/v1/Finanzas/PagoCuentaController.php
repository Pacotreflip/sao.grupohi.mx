<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 01/06/2018
 * Time: 17:03 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Dingo\Api\Exception\ValidationHttpException;
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
        $this->pagoCuentaRepository = $pagoCuentaRepository;
        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:registrar_pago_cuenta', ['only' => ['store']]);
    }

    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $rules = [
            'cumplimiento' => ['required', 'date'],
            'vencimiento' => ['required', 'date'],
            'fecha' => ['required', 'date'],
            'monto' => ['required', 'string',],
            'destino' => ['required', 'string',],
            'observaciones' => ['string',],
            'id_empresa' => ['required', 'exists:cadeco.empresas,id_empresa'],
            'id_costo' => ['required', 'exists:cadeco.costos,id_costo']
        ];

        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new ValidationHttpException($validator->errors());
        } else {
            $this->pagoCuentaRepository->create($request->all());
            return $this->response()->created();
        }
    }
}