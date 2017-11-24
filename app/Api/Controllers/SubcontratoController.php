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
     *
     *       ...
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