<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 01:13 AM
 */

namespace Ghi\Api\Controllers\v1;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\SucursalRepository;
use Ghi\Domain\Core\Transformers\SucursalTransformer;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SucursalController extends Controller
{
    use Helpers;

    private $sucursal;

    /**
     * SucursalController constructor.
     * @param SucursalRepository $sucursal
     */
    public function __construct(SucursalRepository $sucursal)
    {
        $this->sucursal = $sucursal;
    }

    /**
     * @api {post} /sucursal Registrar Sucursal
     * @apiVersion 1.0.0
     * @apiGroup Sucursal
     *
     * @apiHeader {String} Authorization Token de autorización
     * @apiHeader {string} database_name Nombre de la Base de Datos para establecer contexto
     * @apiHeader {string} id_obra ID De la obra sobre la que se desea extablecer el contexto
     *
     * @apiParam {Number} id_empresa Identificador de la Empresa a la que pertenecerá la Sucursal
     * @apiParam {String{max:255}} descripcion Descripción de la Sucursal
     * @apiParam {String{max:255}} [direccion] Dirección de la Sucursal
     * @apiParam {String{max:255}} [ciudad] Ciudad de la Sucursal
     * @apiParam {String{max:255}} [estado] Estado de la Sucursal
     * @apiParam {Number{5}} [codigo_postal] CP de la Sucursal
     * @apiParam {String{max:255}} [telefono] Teléfono de la Sucursal
     * @apiParam {String{max:255}} [fax] FAX de la Sucursal
     * @apiParam {String{max:255}} [contacto] Nombre del Contacto de la Sucursal
     * @apiParam {String{1}="N","S"} [casa_central] Indica si es o no Casa Central
     * @apiParam {String{max:50}} [email] Email de la Sucursal
     * @apiParam {String{max:50}} [cargo] Cargo de la Sucursal
     * @apiParam {String{max:50}} [telefono_movil] Teléfono Móvil de la Sucursal
     * @apiParam {String{max:500}} [observaciones] Observaciones
     *
     * @apiError StoreResourceFailedException Error al registrar una Sucursal
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
     * @apiSuccess (200) {Object} data Datos de la Sucursal Registrada
     * @apiSuccessExample Success-Response
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *       "id_sucursal": "123",
     *       "id_empresa": "123",
     *       "descripcion": "Descripción",
     *       "UsuarioRegistro": "0001",
     *       "FechaHoraRegistro": "2000-01-01 12:00:00",
     *       ...
     *     }
     *   }
     */
    public function store(Request $request)
    {
        //Reglas de validación para crear una sucursal
        $rules = [
            'id_empresa' => ['required', 'integer', 'exists:cadeco.empresas,id_empresa'],
            'descripcion' => ['required', 'string', 'max:255', 'unique:cadeco.sucursales,descripcion,NULL,id_sucursal,id_empresa,' . $request->id_empresa],
            'direccion' =>  ['string', 'max:255'],
            'ciudad' => ['string', 'max:255'],
            'estado' => ['string', 'max:255'],
            'codigo_postal' => ['digits:5'],
            'telefono' => ['string', 'max:255'],
            'fax' => ['string', 'max:255'],
            'contacto' => ['string', 'max:255'],
            'casa_central' => ['string', 'max:1', 'regex:"[SN]"'],
            'email' => ['string', 'max:50', 'email'],
            'cargo' => ['string', 'max:50'],
            'telefono_movil' => ['string', 'max:50'],
            'observaciones' => ['string', 'max:500']
        ];

        //Mensajes de error personalizados para cada regla de validación
        $messages = [
            'casa_central' => 'El campo CASA CENTRAL solo acepta los tipos S y N'
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules, $messages);

        try {
            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la sucursal', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();

                $sucursal = $this->sucursal->create($request->all());

                DB::connection('cadeco')->commit();

                return $this->response->item($sucursal, new SucursalTransformer());
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}