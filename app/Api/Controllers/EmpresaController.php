<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/11/2017
 * Time: 01:13 PM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentEmpresaRepository;
use Ghi\Domain\Core\Transformers\EmpresaTransformer;
use Ghi\Http\Controllers\Controller;

class EmpresaController extends Controller
{
    use Helpers;

    private $empresa;

    public function __construct(EloquentEmpresaRepository $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @api {post} /empresa Registrar Empresa
     * @apiVersion 1.0.0
     * @apiGroup Empresa
     * @apiParam {String} rfc RFC de la Empresa
     * @apiParam {String} razon_social Razón Social de la Empresa
     * @apiParam {Number} tipo_empresa Tipo de Empresa
     * @apiParam {Number} [dias_credito]
     * @apiParam {}
     * @apiParam {}
     * @apiParam {}
     * @apiParam {}
     * @apiParam {}
     * @apiParam {}
     *
     * @apiError StoreResourceFailedException Error al registrar una Empresa
     * @apiErrorExample Error-Response:
     *   HTTP/1.1 422 Unprocessable Entity
     *   {
     *     "message": "error descropton",
     *     "errors": {
     *       "param": ["error 1", "error 2"]
     *       ...
     *     },
     *     "status_code": 422
     *   }
     *
     * @apiSuccess (200) {Object} data Datos de la Empresa Registrada
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *       "id_empresa": "xxx",
     *       "tipo_empresa": "x",
     *       "razon_social": "Razón Social",
     *       "rfc": "000000XXX"
     *     }
     *   }
     */
    public function store(Request $request)
    {
        $empresa = $this->empresa->create($request->all());
        return $this->response->item($empresa, new EmpresaTransformer());
    }
}