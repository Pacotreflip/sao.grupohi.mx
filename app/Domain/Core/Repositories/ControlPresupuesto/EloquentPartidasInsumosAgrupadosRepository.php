<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 07/02/2018
 * Time: 04:32 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;

class EloquentPartidasInsumosAgrupadosRepository implements PartidasInsumosAgrupadosRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados
     */
    protected $model;


    public function __construct(PartidasInsumosAgrupados $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }


    public function where(array $where)
    {
        $this->model = $this->model->where($where);

        return $this;
    }

    /**
     * Crea relaciones eloquent
     * @param array|string $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }


}