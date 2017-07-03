<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 05:55 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Ghi\Domain\Core\Contracts\Identificador;
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
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador de la Cuenta de Almacen que se va a mostrar
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

}