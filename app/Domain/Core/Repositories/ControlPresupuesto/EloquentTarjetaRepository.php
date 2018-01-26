<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:37 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;

class EloquentTarjetaRepository implements TarjetaRepository
{
    /**
     * @var Tarjeta
     */
    protected $model;

    /**
     * EloquentTarjetaRepository constructor.
     * @param Tarjeta $model
     */
    public function __construct(Tarjeta $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las Tarjetas
     * @return \Illuminate\Database\Eloquent\Collection|Tarjeta
     */
    public function all()
    {
        return $this->model->get();
    }

    public function lists() {
        return $this->model->lists('descripcion','id');
    }
}