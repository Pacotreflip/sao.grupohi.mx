<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/11/2017
 * Time: 01:13 PM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Transformers\EmpresaTransformer;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    use Helpers;

    private $empresa;

    public function __construct(EmpresaRepository $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @api {post} /empresa Registrar Empresa
     * @apiVersion 1.0.0
     * @apiGroup Empresa
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
        //Reglas de validación para crear una empresa
        $rules = [
            'rfc' => ['required', 'unique:cadeco.empresas', 'string', 'max:16'],
            'tipo_empresa' => ['required', 'integer'],
            'razon_social' => ['required', 'unique:cadeco.empresas', 'string', 'max:255'],
            'dias_credito' => ['integer'],
            'formato' => ['string', 'max:64'],
            'cuenta_contable' => ['string', 'max:16'],
            'tipo_cliente' => ['integer'],
            'porcentaje' => ['numeric', 'min:0'],
            'no_proveedor_virtual' => ['integer'],
            'personalidad' => ['integer']
        ];

        //Mensajes de error personalizados para cada regla de validación
        $messages = [
            'rfc.unique' => 'Ya existe una Empresa con el RFC proporcionado',
            'razon_social.unique' => 'Ya existe una Empresa con la Razón Social proporcionada'
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules, $messages);

        try {
            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la empresa', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();

                //Crear empresa nueva si la validación no arroja ningún error
                $empresa = $this->empresa->create($request->all());

                DB::connection('cadeco')->commit();

                return $this->response->item($empresa, new EmpresaTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }
}