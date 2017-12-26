<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository;
use Ghi\Domain\Core\Transformers\ContratoTransformer;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    use Helpers;

    private $contrato;

    /**
     * ContratoController constructor.
     * @param ContratoRepository $contrato
     */
    public function __construct(ContratoRepository $contrato)
    {
        $this->contrato = $contrato;
    }

    /**
     * @api {patch} /contrato/{id} Actualizar Contrato
     * @apiVersion 1.0.0
     * @apiGroup Contrato
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {String{max:255}} [descripcion] Descripción del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:16}} [unidad] Unidad de medida del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Number{max:16}} [cantidad_original] Cantidad del nuevo contrato adjunto al contrato proyectado
     * @apiParam {String{max:140}} [clave] Clave del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [id_marca] Marca del nuevo contrato adjunto al contrato proyectado
     * @apiParam {Integer} [id_modelo] Modelo del nuevo contrato adjunto al contrato proyectado
     *
     * @apiError StoreResourceFailedException Error al registrar un Contrato
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
     *       "id_transaccion": 00000
     *       "descripcion": "ABCDE.....",
     *       "unidad": "ABCDE...",
     *       "cantidad_original": "000",
     *       "cantidad_proyectada": "000",
     *       "clave": "XXXXXX",
     *       "id_marca": 000,
     *       "id_modelo": 000,
     *     }
     *   }
     */
    public function update(Request $request, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            if (!$contrato = $this->contrato->find($id)) {
                throw new ResourceException('No se encontró el Contrato que se desea actualizar');
            }
            if (EloquentContratoProyectadoRepository::validarNivel(Contrato::where('id_transaccion', '=', $contrato->id_transaccion)->get(['nivel'])->toArray(), $contrato->nivel)) {
                //Exception cuando no es un contrato hijo
                throw new ResourceException('El Contrato no Puede se Actualizado ya que Cuenta con Niveles Subsecuentes');
            }

            $rules = [
                //'descripcion' => ['max:255', 'filled', 'unique:cadeco.contratos,descripcion,' . $id . ',id_concepto,id_transaccion,' . $contrato->id_transaccion],
                //'unidad' => ['max:16', 'exists:cadeco.unidades,unidad', 'filled'],
                'cantidad_original' => ['numeric', 'min:0', 'filled'],
                'cantidad_presupuestada' => ['numeric', 'min:0', 'filled'],
                //'clave' => ['max:140', 'string', 'filled'],
                //'id_marca' => ['integer'],
                //'id_modelo' => ['integer']
            ];

            $validator = app('validator')->make($request->all(), $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new UpdateResourceFailedException('Error al actualizar el Contrato', $validator->errors());
            } else {

                $contrato = $this->contrato->update($request->all(), $id);

                DB::connection('cadeco')->commit();

                return $this->response()->item($contrato, new ContratoTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}