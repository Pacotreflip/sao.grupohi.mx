<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:37 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoOrdenRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;

class EloquentTipoOrdenRepository implements TipoOrdenRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden
     */
    protected $model;

    /**
     * EloquentTipoOrdenRepository constructor.
     * @param \Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden $model
     */
    public function __construct(TipoOrden $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los tipos de orden
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoOrden
     */
    public function all()
    {
        return $this->model->get();
    }
}