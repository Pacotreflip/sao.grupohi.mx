<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\AlmacenRepository;
use \Ghi\Domain\Core\Models\Almacen;

class EloquentAlmacenRepository implements AlmacenRepository
{
    /**
     * @var Almacen
     */
    protected $model;


    /**
     * EloquentAlmacenRepository constructor.
     * @param Almacen $model
     */
    public function __construct(Almacen $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Almacenes
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador de la Cuenta de Almacen que se va a mostrar
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Regresa los Almacenes Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model;

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }
}