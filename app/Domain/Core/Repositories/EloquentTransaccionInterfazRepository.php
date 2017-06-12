<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\TransaccionInterfazRepository;
use Ghi\Domain\Core\Models\TransaccionInterfaz;

class EloquentTransaccionInterfazRepository implements TransaccionInterfazRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\TransaccionInterfaz $model
     */
    private $model;

    /**
     * EloquentTransaccionInterfazRepository constructor.
     * @param \Ghi\Domain\Core\Models\TransaccionInterfaz $model
     */
    public function __construct(TransaccionInterfaz $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene una Transacción Interfáz por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\TransaccionInterfaz
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtiene todas las Transacciones Interfáz
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TransaccionInterfaz
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Obtiene todas las Trasacciones Interfáz en forma de lista para combos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TransaccionInterfaz
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id_transaccion_interfaz');
    }
}