<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 29/05/2018
 * Time: 04:27 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Dingo\Api\Exception\ValidationHttpException;
use Ghi\Domain\Core\Contracts\Finanzas\ComprobanteFondoFijoRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Ghi\Domain\Core\Contracts\FondoRepository;
use Dingo\Api\Http\Request;
use JWTAuth;

/**
 * Class FondoController
 * @package Ghi\Api\Controllers\v1
 */
class ComprobanteFondoFijoController extends BaseController
{
    /**
     * @var FondoRepository
     */
    protected $comprobanteFondoFijoRepository;

    /**
     * FondoController constructor.
     *
     * @param FondoRepository $fondoRepository
     */
    public function __construct(ComprobanteFondoFijoRepository $comprobanteFondoFijoRepository)
    {
        $this->comprobanteFondoFijoRepository = $comprobanteFondoFijoRepository;
    }

    /**
     * @return mixed
     */
    public function search(Request $request)
    {
        $rules = [
            //Validaciones de Transaccion
            'q' => ['required', 'string',],
            'limit' => ['required', 'int',],
        ];
        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            //Caer en excepción si alguna regla de validación falla
            throw new ValidationHttpException($validator->errors());
        } else {
            try {
                $comprobanteFondoFijo = $this->comprobanteFondoFijoRepository
                    ->like(["referencia" => $request->q, "observaciones" => $request->q, 'numero_folio' => $request->q])
                    ->limit($request->limit)
                    ->with($request->with)
                    ->all();
                return response()->json($comprobanteFondoFijo, 200);
            } catch (\Exception $e) {
                return response()->json([
                    $e->getTraceAsString(),
                ], 500);
            }
        }
    }
}