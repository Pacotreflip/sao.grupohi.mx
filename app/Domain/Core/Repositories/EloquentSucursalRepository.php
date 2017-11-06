<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 3:39 AM
 */

namespace Ghi\Domain\Core\Repositories;


use Dingo\Api\Exception\ResourceException;
use Ghi\Domain\Core\Contracts\SucursalRepository;
use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Database\Eloquent\Collection;

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
     * Obtiene todas las sucursales
     * @return Collection|Sucursal
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Obtiene una Sucursal por si ID
     * @return Sucursal
     */
    public function find(int $id)
    {
        if($item = $this->model->find($id)) {
            return $item;
        } else {
            throw new ResourceException('No existe una Sucursal con el ID proporcionado');
        }
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
                //'' => ['required'],
                //'' => ['required'],
                //'' => ['required']
            ];

            //Mensajes de error personalizados para cada regla de validación
            $messages = [
                //'' => '',
                //'' => ''
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules, $messages);

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