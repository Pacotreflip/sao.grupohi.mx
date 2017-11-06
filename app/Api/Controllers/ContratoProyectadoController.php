<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository;
use Ghi\Domain\Core\Transformers\TransaccionTransformer;
use Ghi\Http\Controllers\Controller;

class ContratoProyectadoController extends Controller
{
    use Helpers;

    private $contrato_proyectado;

    public function __construct(EloquentContratoProyectadoRepository $contrato_proyectado)
    {
        $this->contrato_proyectado = $contrato_proyectado;
    }

    /**
     * @api {post} /contrato_proyectado Registrar Contrato Proyectado
     * @apiVersion 1.0.0
     * @apiGroup Contrato Proyectado
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {String{max:16}} rfc RFC de la Empresa
     * @apiParam {String{max:255}} razon_social Razón Social de la Empresa
     * @apiParam {Number} tipo_empresa Tipo de Empresa
     * @apiParam {Number} [dias_credito] Días de Crédito
     * @apiParam {String{max:64}} [formato] Formato de la Empresa
     * @apiParam {String{max:16}} [cuenta_contable] Cuenta Contable de la empresa
     * @apiParam {Number} [tipo_cliente] Tipo de Cliente
     * @apiParam {Number{min:0}} [porcentaje] Porcentaje
     * @apiParam {Number} [no_proveedor_virtual] Número de Proovedor Virtual
     * @apiParam {Nmber} [personalidad] Personalidad
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
    public function store(Request $request)
    {
        $contrato_proyectado = $this->contrato_proyectado->create($request->all());
        return $this->response->item($contrato_proyectado, new ContratoPro());
    }

    public function update() {

    }
}