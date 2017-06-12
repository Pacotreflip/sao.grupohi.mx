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
     * Obtiene una cuenta contable por su Id
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function getById($id)
    {
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