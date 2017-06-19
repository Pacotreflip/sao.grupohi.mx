<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Models\CuentaContable;

class EloquentCuentaContableRepository implements CuentaContableRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\CuentaContable
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\CuentaContable $model
     */
    public function __construct(CuentaContable $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las cuentas contables
     * @param null|array|string $with
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\CuentaContable
     */
    public function all($with = null)
    {
        if($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function find($id , $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->find($id);
        }
        return $this->model->find($id);
    }
}