<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:37 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoFiltroRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoOrdenRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;

class EloquentTipoFiltroRepository implements TipoFiltroRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro
     */
    protected $model;

    /**
     * EloquentTipoOrdenRepository constructor.
     * @param \Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro $model
     */
    public function __construct(TipoFiltro $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las Tarjetas
     * @return \Illuminate\Database\Eloquent\Collection|TipoFiltro
     */
    public function all()
    {
        return $this->model->get();
    }

    public function lists()
    {
        return $this->model->lists('descripcion', 'id');
    }
}