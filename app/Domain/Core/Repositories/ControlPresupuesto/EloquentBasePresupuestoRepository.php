<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 11/01/2018
 * Time: 11:46 AM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;

class EloquentBasePresupuestoRepository implements BasePresupuestoRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto
     */
    private $model;

    /**
     * EloquentObraRepository constructor.
     * @param \Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto $model
     */
    public function __construct(BasePresupuesto $model)
    {
        $this->model = $model;
    }
    /**
     * @return BasePresupuesto
     *
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $value valor de busqueda de basePresupuesto de acuerdo a su id
     * @return mixed
     */
    public function findBy($value)
    {
        return $this->model->where('id', $value)->get();
    }



}