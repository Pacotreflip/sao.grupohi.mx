<?php

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Transformers\SubcontratoTransformer;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SubcontratoController extends Controller
{
    use Helpers;


    /**
     * @var SubcontratoRepository
     */
    private $subcontrato;

    /**
     * SubcontratoController constructor.
     * @param SubcontratoRepository $subcontrato
     */
    public function __construct(SubcontratoRepository $subcontrato)
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
     * @apiParam {Integer} id_antecedente Id del Contrato Proyectado al cual hace Feferencia el Subcontrato
     * @apiParam {Date} fecha Fecha del Subcontrato
     * @apiParam {Integer} id_costo Id del Costo Asociado al Subcontrato
     * @apiParam {Integer} id_empresa Id de la Empresa Asociada al Subcontrato
     * @apiParam {Integer} id_moneda Id de la Moneda del Subcontrato
     * @apiParam {Numeric} [anticipo] Porcentaje de Anticipo al Subcontrato
     * @apiParam {Numeric} [retencion] Porcentaje de Retención del Subcontrato
     * @apiParam {String{max:64}} [referencia] Referencia unica del Subcontrato
     * @apiParam{String{max:4096}} observaciones Observaciones del Subcontrato
     * @apiParam {Object[]} items Items del Subcontrato
     * @apiParam {Integer} items.id_concepto Id Concepto del Contrato Asociado al Subcontrato
     * @apiParam {Numeric} items.cantidad Cantidad del Item del Subcontrato
     * @apiParam {Numeric} items.precio_unitario Precio Unitario del Item del SubcoapiParam
     *
     * @apiError StoreResourceFailedException Error al registrar un Subcontrato
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
     * @apiSuccess (200) {Object} data Datos del Subcontrato Registrado
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *        "id_antecedente": 12345,
     *        "fecha": "2017-01-01 00:00:00.000",
     *        "id_costo": 123,
     *        "id_empresa": 123,
     *        "id_moneda": 1,
     *        "referencia": "Prueba API",
     *        "opciones": 2,
     *        "id_obra": "1",
     *        "FechaHoraRegistro": "2017-01-01 12:00:00",
     *        "tipo_transaccion": 51,
     *        "comentario": "I;01/01/2017 11:11:18;SAO|usuario|",
     *        "id_transaccion": 1234,
     *        "saldo": "37500.0",
     *        "monto": "37500.0",
     *        "impuesto": 12345.67,
     *        "anticipo_saldo": 0,
     *        "anticipo_monto": 0
     *     }
     *   }
     */
    public function store(Request $request)
    {
        try {
            //Reglas de validación para crear un subcontrat
            $rules = [
                //Validaciones de Subcontrato
                'id_antecedente' => ['required', 'integer', 'exists:cadeco.transacciones,id_transaccion,tipo_transaccion,' . Tipo::CONTRATO_PROYECTADO],
                'fecha' => ['required', 'date'],
                'id_costo' => ['required', 'integer', 'exists:cadeco.costos,id_costo'],
                'id_empresa' => ['required', 'integer', 'exists:cadeco.empresas,id_empresa'],
                'id_moneda' => ['required', 'integer', 'exists:cadeco.monedas,id_moneda'],
                'anticipo' => ['numeric'],
                'retencion' => ['numeric'],
                'referencia' => ['string', 'required', 'max:64', 'unique:cadeco.transacciones,referencia,NULL,id_transaccion,tipo_transaccion,' . Tipo::SUBCONTRATO],
                'observaciones' => ['string', 'max:4096'],
                'items' => ['required', 'array'],
                'items.*.id_concepto' => ['distinct', 'required', 'exists:cadeco.contratos,id_concepto,id_transaccion,' . $request->id_antecedente . ',unidad,NOT_NULL'],
                'items.*.cantidad' => ['required', 'numeric'],
                'items.*.precio_unitario' => ['required', 'numeric']
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($request->all(), $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear el Subcontrato', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();

                $subcontrato = $this->subcontrato->create($request->all());

                DB::connection('cadeco')->commit();

                return $this->response()->item($subcontrato, new SubcontratoTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}