<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 01:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentSucursalRepository;
use Ghi\Domain\Core\Transformers\SucursalTransformer;
use Ghi\Http\Controllers\Controller;

class SucursalController extends Controller
{
    use Helpers;

    private $sucursal;

    /**
     * SucursalController constructor.
     * @param EloquentSucursalRepository $sucursal
     */
    public function __construct(EloquentSucursalRepository $sucursal)
    {
        $this->sucursal = $sucursal;
    }

    /**
     * @api {post} /sucursal Registrar Sucursa
     * @apiVersion 1.0.0
     * @apiGroup Sucursal
     * @apiParam {Number} id_empresa Identificador de la Empresa a la que pertenecerá la Sucursal
     * @apiParam {String} descripcion Descripción de la Sucursal
     * @apiParam {String} [direccion] Dirección de la Sucursal
     * @apiParam {String} [ciudad] Ciudad de la Sucursal
     * @apiParam {String} [estado] Estado de la Sucursal
     * @apiParam {Number} [codigo_postal] CP de la Sucursal
     * @apiParam {String} [telefono] Teléfono de la Sucursal
     * @apiParam {String} [fax] FAX de la Sucursal
     * @apiParam {String} [contacto] Nombre del Contacto de la Sucursal
     * @apiParam {String{1}="N","S"} [casa_central] Indica si es o no Casa Central
     * @apiParam {String} [email] Email de la Sucursal
     * @apiParam {String} [cargo] Cargo de la Sucursal
     * @apiParam {String} [telefono_movil] Teléfono Móvil de la Sucursal
     * @apiParam {String} [observaciones] Observaciones
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
        $sucursal = $this->sucursal->create($request->all());
        return $this->response->item($sucursal, new SucursalTransformer());
    }
}