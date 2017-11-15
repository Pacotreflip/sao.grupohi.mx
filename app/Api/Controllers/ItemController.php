<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 14/11/2017
 * Time: 04:14 PM
 */

namespace Ghi\Api\Controllers;

use Ghi\Domain\Core\Repositories\EloquentItemRepository;
use Ghi\Domain\Core\Transformers\ItemTransformer;
use Ghi\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;


class ItemController extends Controller
{
    use Helpers;


    /**
     * @var EloquentItemRepository
     */
    private $item;

    /**
     * ItemController constructor.
     * @param EloquentItemRepository $item
     */
    public function __construct(EloquentItemRepository $item)
    {
        $this->item = $item;
    }

    /**
     * @api {post} /subcontrato/item Registrar Item adjunto a un Subcontrato
     * @apiVersion 1.0.0
     * @apiGroup Items
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiError StoreResourceFailedException Error al registrar un Item adjunto a un Subcontrato
     * @apiErrorExample Error-Response
     *   HTTP/1.1 422 Unprocessable Entity
     *   {
     *     "message": "error description",
     *     "errors": {
     *       "param": ["error 1", "error 2"]
     *       ...
     *     },
     *     "status_code": 422
     *   }
     *
     * @apiSuccess (200) {Object} data Datos del Item adjunto a un Subcontrato
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
        $item = $this->item->create($request->all());
        return $this->response->item($item, new ItemTransformer());
    }


}