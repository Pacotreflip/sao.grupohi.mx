<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Transformers\ContratoTransformer;
use Ghi\Http\Controllers\Controller;

class ContratoController extends Controller
{
    use Helpers;

    private $contrato;

    public function __construct(ContratoRepository $contrato)
    {
        $this->contrato = $contrato;
    }

    /**
     * @api {patch} /contrato Actualizar Informción de un Contrato
     * @apiVersion 1.0.0
     * @apiGroup Contrato
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam
     * @apiParam
     * @apiParam
     * @apiParam
     *
     * @apiError StoreResourceFailedException Error al registrar una Empresa
     * @apiErrorExample Error-Response
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
     *       "rfc": "000000XXX",
     *       ...
     *     }
     *   }
     */
    public function update(Request $request, $id)
    {
        $contrato = $this->contrato->update($request->all(), $id);
        return $this->response->item($contrato, new ContratoTransformer());
    }
}