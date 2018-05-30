<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 29/05/2018
 * Time: 12:52 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Dingo\Api\Exception\ValidationHttpException;
use Ghi\Domain\Core\Contracts\Finanzas\ReposicionFondoFijoRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;

/**
 * Class ReposicionFondoFijoController
 * @package Ghi\Api\Controllers\v1\Finanzas\ReposicionFondoFijo
 */
class ReposicionFondoFijoController extends BaseController
{
    /**
     * @var ReposicionFondoFijoRepository
     */
    protected $reposicionFondoFijoRepository;

    /**
     * TraspasoCuentasController constructor.
     *
     * @param TraspasoCuentasRepository $traspasoCuentas
     */
    public function __construct(ReposicionFondoFijoRepository $reposicionFondoFijoRepository)
    {
        $this->reposicionFondoFijoRepository = $reposicionFondoFijoRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {

        $rules = [
            //Validaciones de Transaccion
            'id_referente' => ['required', 'int', 'exists:cadeco.fondos,id_fondo'],
            'fecha_cumplimiento' => ['required', 'date_format:Y-m-d',],
            'fecha_vencimiento' => ['required', 'date_format:Y-m-d',],
            'monto' => ['required', 'string',],
            'destino' => ['required', 'string',],
            'observaciones' => ['string',],
            'id_antecedente' => ['int',],
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            //Caer en excepción si alguna regla de validación falla
            throw new ValidationHttpException($validator->errors());
        } else {
            try {
                $record = $this->reposicionFondoFijoRepository->create($request->all());
                // Si $record es un string hubo un error al guardar el traspaso
                return response()->json([
                    'data' =>
                        [
                            'traspaso' => $this->reposicionFondoFijoRepository->find($record->id_traspaso),
                        ],
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    $e->getTraceAsString(),
                ], 500);
            }
        }
    }
}