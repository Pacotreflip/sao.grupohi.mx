<?php

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentSubcontratoRepository;
use Ghi\Http\Controllers\Controller;

class SubcontratoController extends Controller
{
    use Helpers;


    /**
     * @var EloquentSubcontratoRepository
     */
    private $subcontrato;

    /**
     * SubcontratoController constructor.
     * @param EloquentSubcontratoRepository $subcontrato
     */
    public function __construct(EloquentSubcontratoRepository $subcontrato)
    {
        $this->subcontrato = $subcontrato;
    }

    /**
     * @api {post} /subcontrato Registrar Subcontrato
     * @apiVersion 1.0.0
     * @apiGroup Subcontrato
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiError StoreResourceFailedException Error al registrar un Subcontrato
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
     * @apiSuccess (200) {Object} data Datos del Subcontrato Registrado
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
        $subcontrato = $this->subcontrato->create($request->all());
        return $this->response->item($subcontrato, new SubcontratoTransformer());
    }
}