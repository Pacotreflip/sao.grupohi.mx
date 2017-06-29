<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 05:55 PM
 */

namespace Ghi\Domain\Core\Repositories;
use Ghi\Domain\Core\Contracts\AlmacenRepository;
use \Ghi\Domain\Core\Models\Almacen;

class EloquentAlmacenRepository implements AlmacenRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Almacen
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\Almacen $model
     */
    public function __construct(Almacen $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Almacenes
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function all($with = null)
    {
        if ($with != null)
            return $this->model->with($with)->get();
        return $this->model->all();
    }
}