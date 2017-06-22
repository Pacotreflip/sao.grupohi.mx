<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 21/06/2017
 * Time: 06:26 PM
 */

namespace Ghi\Domain\Core\Repositories;
use Ghi\Domain\Core\Contracts\PolizasRepository;
use Ghi\Domain\Core\Models\polizas;


class EloquentPolizasRepository implements PolizasRepository
{

    /**
 * @var \Ghi\Domain\Core\Models\Polizas
 */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\CuentaContable $model
     */
    public function __construct(Polizas $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Polizas
     */
    public function all($with = null)
    {
        if($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }
}