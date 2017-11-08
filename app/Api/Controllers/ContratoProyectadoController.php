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
        $contrato_proyectado = $this->contrato_proyectado->create($request->all());
        return $this->response->item($contrato_proyectado, new TransaccionTransformer());
    }
}