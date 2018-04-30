<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 25/04/2018
 * Time: 05:07 PM
 */

namespace Ghi\Api\Controllers\v1\SistemaContable;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;

/**
 * Class PolizaTipoController
 * @package Ghi\Api\Controllers\v1\SistemaContable
 */
class PolizaTipoController extends BaseController
{
    /**
     * @var PolizaTipoRepository
     */
    private $polizaTipoRepository;

    /**
     * @param PolizaTipoRepository $polizaTipoRepository
     */
    public function __construct(PolizaTipoRepository $polizaTipoRepository)
    {
        $this->polizaTipoRepository = $polizaTipoRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){
        $resp = $this->polizaTipoRepository->paginate($request->all());
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }

    /**
     *  Elimina un registro de Plantilla
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function delete($id, Request $request)
    {

        try {
            $this->polizaTipoRepository->delete($request->all(), $id);

            return response()->json(['data' =>
                [
                    'id' => $id
                ]
            ], 200);
        }  catch (\Exception $e){
            return response()->json([
                'data' => $e->getTraceAsString()], 500);
        }
    }
}