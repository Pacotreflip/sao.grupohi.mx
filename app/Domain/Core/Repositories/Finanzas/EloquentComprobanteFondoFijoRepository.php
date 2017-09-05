<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

class EloquentComprobanteFondoFijoRepository implements ComprobanteFondoFijoRepository
{
    /**
     * @var ComprobanteFondoFijo
     */
    protected $model;

    /**
     * EloquentComprobanteFondoFijoRepository constructor.
     * @param ComprobanteFondoFijo $model
     */
    public function __construct(ComprobanteFondoFijo $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Comprobantes de Fondo Fijo
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }


    /**
     * Guarda un nuevo registro de Comprobante de Fondo Fijo
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * Elimina el Comprobante de Fondo Fijo
     * @param array $data
     * @param $id
     * @return mixed
     *
     */
    public function delete(array $data, $id)
    {
        $this->model->where('id', '=', $id)->delete();
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}