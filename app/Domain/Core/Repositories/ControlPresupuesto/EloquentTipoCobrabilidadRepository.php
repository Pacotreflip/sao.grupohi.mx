<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:37 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoCobrabilidadRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad;

class EloquentTipoCobrabilidadRepository implements TipoCobrabilidadRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad
     */
    protected $model;

    /**
     * EloquentTipoOrdenRepository constructor.
     * @param \Ghi\Domain\Core\Models\ControlPresupuesto\TipoCobrabilidad $model
     */
    public function __construct(TipoCobrabilidad $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los tipos de orden
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCobrabilidad
     */
    public function all()
    {
        return $this->model->get();
    }

}