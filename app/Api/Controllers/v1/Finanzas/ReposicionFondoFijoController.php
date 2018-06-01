<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 29/05/2018
 * Time: 12:52 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Finanzas\ReposicionFondoFijoRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use Validator;
use JWTAuth;

/**
 * Class ReposicionFondoFijoController
 * @package Ghi\Api\Controllers\v1\Finanzas\ReposicionFondoFijo
 */
class ReposicionFondoFijoController extends BaseController
{
    use Helpers;
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
        // Email array validator
        Validator::extend('uniqueid_antecedente', function($attribute, $value, $parameters, $validator) {
            $option = $this->reposicionFondoFijoRepository->where([$attribute => $value])->get();
            if (count($option->toArray())) {
                return false;
            } else {
                return true;
            }
        });

        $rules = [
            //Validaciones de Transaccion
            'id_referente' => ['required', 'int', 'exists:cadeco.fondos,id_fondo'],
            'cumplimiento' => ['required', 'date_format:Y-m-d',],
            'vencimiento' => ['required', 'date_format:Y-m-d',],
            'monto' => ['required', 'string',],
            'destino' => ['required', 'string',],
            'observaciones' => ['string',],
            'id_antecedente' => ['int','uniqueid_antecedente'],
        ];
        $messages = [ 'uniqueid_antecedente' => 'El Comprobante seleccionado ya cuenta con una reposición de cheque' ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules,$messages);
        if (count($validator->errors()->all())) {
            //Caer en excepción si alguna regla de validación falla
            throw new ValidationHttpException($validator->errors());
        } else {
            $this->reposicionFondoFijoRepository->create($request->all());

            return $this->response()->created();
        }
    }
}