<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 3:39 AM
 */

namespace Ghi\Domain\Core\Repositories;


use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\SucursalRepository;
use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Support\Facades\DB;

class EloquentSucursalRepository implements SucursalRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Sucursal
     */
    private $model;

    /**
     * EloquentSucursalRepository constructor.
     * @param Sucursal $model
     */
    public function __construct(Sucursal $model)
    {
        $this->model = $model;
    }

    /**
     * Crea un nuevo registro de Sucursal
     * @param array $data
     * @return Sucursal
     * @throws \Exception
     */
    public function create(array $data) {
        DB::connection('cadeco')->beginTransaction();

        try {
            //Reglas de validación para crear una sucursal
            $rules = [
                'id_empresa' => ['required', 'integer', 'exists:cadeco.empresas,id_empresa'],
                'descripcion' => ['required', 'string', 'max:255'],
                'direccion' =>  ['string', 'max:255'],
                'ciudad' => ['string', 'max:255'],
                'estado' => ['string', 'max:255'],
                'codigo_postal' => ['digits:5'],
                'telefono' => ['string', 'max:255'],
                'fax' => ['string', 'max:255'],
                'contacto' => ['string', 'max:255'],
                'casa_central' => ['string', 'max:1', 'regex:"[sSnN]"'],
                'email' => ['string', 'max:50'],
                'cargo' => ['string', 'max:50'],
                'telefono_movil' => ['string', 'max:50'],
                'observaciones' => ['string', 'max:500']
            ];

            //Mensajes de error personalizados para cada regla de validación
            //$messages = [
                //'' => '',
                //'' => ''
           // ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules);

            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la sucursal', $validator->errors());
            } else {
                //Crear sucursal nueva si la validación no arroja ningún error
                $sucursal = $this->model->create($data);
                DB::connection('cadeco')->commit();
                return $sucursal;
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}