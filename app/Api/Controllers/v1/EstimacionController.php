<?php

namespace Ghi\Api\Controllers\v1;

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
     * @apiParam {Integer} id_antecedente Id del Subcontrato al cuál está haciendo referencia la Estimación
     * @apiParam {Date} fecha Fecha de registro
     * @apiParam {Integer} id_empresa Id de la Empresa
     * @apiParam {Integer} id_moneda Id del Tipo de Moneda
     * @apiParam {Date} vencimiento Fecha de Vencimiento de la Estimación
     * @apiParam {Date} cumplimiento Fecha de Cumplimiento de la Estimación
     * @apiParam {String{max:4096}} observaciones Observaciones de la Estimación
     * @apiParam {String{max:64}} referencia Referencia de la Estimación
     * @apiParam {Object[]} items Items de la Estimación
     * @apiParam {Integer} items.item_antecedente Id del Item Antecedente
     * @apiParam {Number} items.cantidad Cantidad del Item de la Estimación
     *
     * @apiError StoreResourceFailedException Error al registrar una Estimación
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
     * @apiSuccess (200) {Object} data Datos de la Estimación Registrada
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     {
     *      "data": {
     *          "id_antecedente": 12345,
     *          "fecha": "2017-11-24 00:00:00.000",
     *          "id_empresa": 123,
     *          "id_moneda": 1,
     *          "vencimiento": "2017-01-03 00:00:00.000",
     *          "cumplimiento": "2017-01-02 00:00:00.000",
     *          "referencia": "Prueba API",
     *          "opciones": 0,
     *          "id_obra": "1",
     *          "FechaHoraRegistro": "2017-01-01 20:00:00",
     *          "tipo_transaccion": 52,
     *          "comentario": "I;01/01/2017 08:11:00;SAO|usuario|",
     *          "id_transaccion": 12345,
     *          "anticipo": "0.0",
     *          "retencion": "0.0",
     *          "saldo": 12345.6,
     *          "monto": 12345.6,
     *          "impuesto": 12345.6
     *        }
     *      }
     *   }
     */
    public function store(Request $request)
    {
        $estimacion = $this->estimacion->create($request);
        return $this->response->item($estimacion, new TransaccionTransformer());
    }
}