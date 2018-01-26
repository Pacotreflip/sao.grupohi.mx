<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:57 AM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\EstatusRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;

class EloquentEstatusRepository implements EstatusRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus
     */
    protected $model;

    /**
     * EloquentTipoOrdenRepository constructor.
     * @param \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus $model
     */
    public function __construct(Estatus $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros del estatus
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\ControlPresupuesto\Estatus
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Obtiene un estatus que coincida con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus
     */
    public function findBy($attribute, $value)
    {
        return $this->model->where($attribute, '=', $value)->first();
    }
}