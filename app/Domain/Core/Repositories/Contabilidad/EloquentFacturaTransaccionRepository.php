<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/06/2018
 * Time: 04:52 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\FacturaTransaccionRepository;

class EloquentFacturaTransaccionRepository implements FacturaTransaccionRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\FacturaTransaccion
     */
    protected $model;

    /**
     * EloquentFacturaTransaccionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\FacturaTransaccion $model
     */
    public function __construct(\Ghi\Domain\Core\Models\Contabilidad\FacturaTransaccion $model)
    {
        $this->model = $model;
    }

    public function all() {
        return $this->model->get();
    }

    /**
     * @param $conditions
     * @return $this
     */
    public function where($conditions)
    {
        $this->model = $this->model->where($conditions);
        return $this;
    }

    public function with($with)
    {
        $this->model = $this->model->with($with);
        return $this;
    }
}