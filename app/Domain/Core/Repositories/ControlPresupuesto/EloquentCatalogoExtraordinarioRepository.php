<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 21/05/2018
 * Time: 04:52 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\CatalogoExtraordinario;

class EloquentCatalogoExtraordinarioRepository implements CatalogoExtraordinarioRepository
{

    protected $model;

    /**
     * EloquentCatalogoExtraordinarioRepository constructor.
     * @param CatalogoExtraordinario $model
     */
    public function __construct(CatalogoExtraordinario $model)
    {
        $this->model = $model;
    }


    public function all()
    {
        return $this->model->get();
    }

    public function lists()
    {
        return $this->model->lists('descripcion', 'id');
    }
}