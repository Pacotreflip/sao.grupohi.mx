<?php

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Transformers\TransaccionTransformer;
use Ghi\Http\Controllers\Controller;

class EstimacionController extends Controller
{
    use Helpers;


    /**
     * @var EstimacionRepository
     */
    private $estimacion;

    /**
     * SubcontratoController constructor.
     * @param EstimacionRepository $estimacion
     */
    public function __construct(EstimacionRepository $estimacion)
    {
        $this->estimacion = $estimacion;
    }

    /**
     * @api {post} /estimacion Registrar Estimación
     * @apiVersion 1.0.0
     * @apiGroup Estimación
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiError StoreResourceFailedException Error al registrar una Estimación
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
     * @apiSuccess (200) {Object} data Datos de la Estimación Registrada
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *
     *       ...
     *     }
     *   }
     */
    public function store(Request $request)
    {
        $estimacion = $this->estimacion->create($request);
        return $this->response->item($estimacion, new TransaccionTransformer());
    }
}