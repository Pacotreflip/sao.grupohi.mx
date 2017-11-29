<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 14/11/2017
 * Time: 04:14 PM
 */

namespace Ghi\Api\Controllers;

use Ghi\Domain\Core\Contracts\ItemRepository;
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
     * @param ItemRepository $item
     */
    public function __construct(ItemRepository $item)
    {
        $this->item = $item;
    }

    /**
     * @api {post} /item Registrar Item
     * @apiVersion 1.0.0
     * @apiGroup Item
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {Integer} [id_transaccion] Id del Subcontrato al cuál se Agregara el Item
     * @apiParam {Numeric} cantidad Cantidad del Item
     * @apiParam {Numeric} precio_unitario Precio Unitario del item
     *
     * @apiError StoreResourceFailedException Error al registrar un Item
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

     * @apiSuccess (200) {Object} data Datos del Item
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *      "data": {
     *         "id_transaccion": "12345",
     *         "cantidad": 12345,
     *         "precio_unitario": 123,
     *         "id_concepto": "12345",
     *         "id_item": 12345
     *      }
     *   }
     */
    public function store(Request $request)
    {
        $item = $this->item->create($request);
        return $this->response->item($item, new ItemTransformer());
    }

    /**
     * @api {patch} /item/{id} Actualizar un Item
     * @apiVersion 1.0.0
     * @apiGroup Item
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {Number} cantidad Cantidad del Item a Acualizar de la Estimación
     *
     * @apiError StoreResourceFailedException Error al Actualizar un Item
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
     * @apiSuccess (200) {Object} data Datos del Item Actualizado
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *        "id_item": 12345,
     *        "id_transaccion": "12345",
     *        "id_antecedente": null,
     *        "item_antecedente": null,
     *        "id_almacen": null,
     *        "id_concepto": "12345",
     *        "id_material": null,
     *        "unidad": null,
     *        "numero": "0",
     *        "cantidad": 1234,
     *        "cantidad_material": "0.0",
     *        "cantidad_mano_obra": "0.0",
     *        "importe": "0.0",
     *        "saldo": "0.0",
     *        "precio_unitario": 123,
     *        "anticipo": "0.0",
     *        "descuento": "0.0",
     *        "precio_material": "0.0",
     *        "precio_mano_obra": "0.0",
     *        "autorizado": "0.0",
     *        "referencia": null,
     *        "estado": "0",
     *        "cantidad_original1": "0.0",
     *        "cantidad_original2": "0.0",
     *        "precio_original1": "0.0",
     *        "precio_original2": "0.0",
     *        "id_asignacion": null
     *      }
     *   }
     */
    public function update(Request $request, $id)
    {
        $item = $this->item->update($request, $id);
        return $this->response->item($item, new ItemTransformer());
    }
}