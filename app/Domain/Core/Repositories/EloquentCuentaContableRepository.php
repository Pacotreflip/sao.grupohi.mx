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

    /**
     * Obtiene las cuentas contables en forma de lista para combos
     * @return \Illuminate\Database\Eloquent\Collection|CuentaContable
     */
    public function lists()
    {
        $data = [];
        foreach ($this->model->all() as $item) {
            $data[$item->id_int_cuenta_contable] = (String) $item->tipoCuentaContable;
        }
        return collect($data);
    }
}