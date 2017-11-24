<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository;
use Ghi\Domain\Core\Transformers\ContratoTransformer;
use Ghi\Domain\Core\Transformers\TransaccionTransformer;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContratoProyectadoController extends Controller
{
    use Helpers;

    private $contrato_proyectado;

    public function __construct(ContratoProyectadoRepository $contrato_proyectado)
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
     *
     * @apiParam {Date} fecha Fecha de Registro del Contrato Proyectado
     * @apiParam {String{max:64}} referencia Referencia del nuevo Contrato Proyectado
     * @apiParam {DateTime} cumplimiento Fecha del inicio de cumplimiento del Contrato Proyectado
     * @apiParam {DateTime} vencimiento Fecha de Vencimiento del Contrato Proyectado
     * @apiParam {Object[]} contratos Contratos para el Contrato Proyectado
     *
     * @apiParam {String{max:255}} contratos.nivel Nivel del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:255}} contratos.descripcion Descripción del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:16}} [contratos.unidad] Unidad de medida del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Number{max:16}} [contratos.cantidad_original] Cantidad del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:140}} [contratos.clave] Clave del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [contratos.id_marca] Marca del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [contratos.id_modelo] Modelo del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Object[]} [contratos.destinos] Destinos del contrato
     * @apiParam {Integer} contratos.destinos.id_concepto ID del Concepto asociado al contrato
     *
     * @apiError StoreResourceFailedException Error al registrar un Contrato Proyectado
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
     * @apiSuccess (200) {Object} data Datos del Contrato Proyectado
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *       "id_transaccion": 31557
     *       "fecha": "2017-11-07 00:00:00.000",
     *       "referencia": "CONTRATO PROYECTADO NUEVO 07-11-2017",
     *       "cumplimiento": "2017-11-06 00:00:00.000",
     *       "vencimiento": "2017-11-07 00:00:00.000",
     *       "id_obra": "1",
     *       "FechaHoraRegistro": "2017-11-07 16:36:15",
     *       "tipo_transaccion": 49,
     *       "opciones": 1026,
     *       "comentario": "I;07/11/2017 04:11:15;SCR|jfesquivel|",
     *     }
     *   }
     */
    public function store(Request $request)
    {
        //Reglas de validación para crear un contrato proyectado
        $rules = [
            //Validaciones de Transaccion
            'fecha' => ['required', 'date'],
            'referencia' => ['required', 'string', 'max:64'],
            'cumplimiento' => ['required', 'date'],
            'vencimiento' => ['required', 'date', 'after:cumplimiento'],
            'contratos' => ['required', 'array'],
            'contratos.*.nivel' => ['required', 'string', 'max:255', 'regex:"^(\d{3}\.)+$"', 'distinct'],
            'contratos.*.descripcion' => ['required', 'string', 'max:255', 'distinct'],
            'contratos.*.unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
            'contratos.*.cantidad_presupuestada' => ['numeric'],
            'contratos.*.clave' => ['string', 'max:140', 'distinct'],
            'contratos.*.id_marca' => ['integer'],
            'contratos.*.id_modelo' => ['integer'],
            'contratos.*.destinos.*.id_concepto' => ['required_with:contratos.*.destinos', 'integer', 'exists:cadeco.conceptos,id_concepto']
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);

        foreach ($request->get('contratos', []) as $key => $contrato) {
            if(array_key_exists('nivel', $contrato)) {
                if (EloquentContratoProyectadoRepository::validarNivel($request->get('contratos', []), $contrato['nivel'])) {
                    foreach (array_only($contrato, ['unidad', 'cantidad_presupuestada', 'destinos']) as $key_campo => $campo) {
                        $validator->errors()->add('contratos.' . $key . '.' . $key_campo, 'El contrato no debe incluir ' . $key_campo . ' ya que tiene niveles subsecuentes');
                    }
                } else {
                    $validator->sometimes(['contratos.' . $key . '.unidad', 'contratos.' . $key . '.cantidad_presupuestada', 'contratos.' . $key . '.destinos'], 'required', function () {
                        return true;
                    });
                }
            }
        }

        try {
            if (count($validator->errors()->all())) {
                throw new StoreResourceFailedException('Error al crear el Contrato Proyectado', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();

                $contrato_proyectado = $this->contrato_proyectado->create($request->all());

                DB::connection('cadeco')->commit();

                return $this->response->item($contrato_proyectado, new TransaccionTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * @api {post} /contrato_proyectado/{id}/addContratos Agregar Contratos Adjuntos a Contrato Proyectado
     * @apiVersion 1.0.0
     * @apiGroup Contrato Proyectado
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {Object[]} contratos Arreglo de Objetos que contiene los contrato a registrar
     * @apiParam {String{max:255}} contratos.nivel Nivel del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:255}} contratos.descripcion Descripción del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:16}} [contratos.unidad] Unidad de medida del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Number{max:16}} [contratos.cantidad_original] Cantidad del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:140}} [contratos.clave] Clave del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [contratos.id_marca] Marca del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [contratos.id_modelo] Modelo del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Object[]} [contratos.destinos] Destinos del contrato
     * @apiParam {Integer} contratos.destinos.id_concepto ID del Concepto asociado al contrato
     *
     * @apiError StoreResourceFailedException Error al registrar un Contrato Proyectado
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
     * @apiSuccess (200) {Object[]} data Contratos agregados al Contrato Proyectado
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": [
     *       {
     *         "id_concepto": 0000,
     *         "id_transaccion": 1111,
     *         "descripcion": "ABCDE.....",
     *         "nivel": "000.000.000.",
     *         "unidad": "ABCDE",
     *         "cantidad_original": "000",
     *         "cantidad_proyectada": "000",
     *         "clave": "XXXXX",
     *         "id_marca": 0000,
     *         "id_modelo": 0000,
     *         "destinos": " [
     *           {
     *             "id_concepto": 00000
     *           }
     *         ]
     *       },
     *       ...
     *     ]
     *   }
     */
    public function addContratos(Request $request, $id) {

        $rules = [
            //Validaciones de Transaccion
            'contratos' => ['required', 'array'],
            'contratos.*.nivel' => ['regex:"^(\d{3}\.)+$"', 'required', 'distinct', 'string', 'max:255', 'unique:cadeco.contratos,nivel,NULL,id_concepto,id_transaccion,' . $id],
            'contratos.*.descripcion' => ['required', 'string', 'max:255'],
            'contratos.*.unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
            'contratos.*.cantidad_presupuestada' => ['numeric'],
            'contratos.*.clave' => ['string', 'max:140', 'distinct'],
            'contratos.*.id_marca' => ['integer'],
            'contratos.*.id_modelo' => ['integer'],
            'contratos.*.destinos.*.id_concepto' => ['required_with:contratos.*.destinos', 'integer', 'exists:cadeco.conceptos,id_concepto']
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);

        $contratos_existentes = Contrato::where('id_transaccion', '=', $id)->get(['nivel'])->toArray();

        foreach ($request->get('contratos', []) as $c) {
            if(array_key_exists('nivel', $c)) {
                $contratos_existentes [] = ['nivel' => $c['nivel']];
            }
        }

        foreach ($request->get('contratos', []) as $key => $contrato) {
            if(array_key_exists('nivel', $contrato)) {
                if (EloquentContratoProyectadoRepository::validarNivel($contratos_existentes, $contrato['nivel'])) {
                    foreach (array_only($contrato, ['unidad', 'cantidad_presupuestada', 'destinos']) as $key_campo => $campo) {
                        $validator->errors()->add('contratos.' . $key . '.' . $key_campo, 'El contrato no debe incluir ' . $key_campo . ' ya que tiene niveles subsecuentes');
                    }
                } else {
                    $validator->sometimes(['contratos.' . $key . '.unidad', 'contratos.' . $key . '.cantidad_presupuestada', 'contratos.' . $key . '.destinos'], 'required', function () {
                        return true;
                    });
                }
            }
        }

        try {
            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al agregar los Contratos', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();

                $contratos = $this->contrato_proyectado->addContratos($request->all(), $id);

                DB::connection('cadeco')->commit();
                return $this->response->collection($contratos, new ContratoTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}