<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\TipoCuentaContableRepository;
use Ghi\Domain\Core\Models\TipoCuentaContable;

class EloquentTipoCuentaContableRepository implements TipoCuentaContableRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\TipoCuentaContable
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoCuentaContable $model
     */
    public function __construct(TipoCuentaContable $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas los Tipos de Cuentas Contables
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TipoCuentaContable
     */
    public function all()
    {
        return $this->model->all();
    }
}