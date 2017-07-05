<?php
namespace Ghi\Domain\Core\Repositories\Compras;
use Ghi\Domain\Core\Contracts\Compras\Identificador;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class EloquentRequisicionRepository implements RequisicionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    protected $model;

    /**
     * EloquentRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Transacciones\Transaccion $model
     */
    public function __construct(Transaccion $model)
    {
        $this->model = $model;
    }
    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador de la Transaccion
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
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
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }
}