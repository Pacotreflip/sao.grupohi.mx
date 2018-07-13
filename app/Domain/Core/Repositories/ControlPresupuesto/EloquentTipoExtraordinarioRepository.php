<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 21/05/2018
 * Time: 01:08 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoExtraordinarioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoExtraordinario;

class EloquentTipoExtraordinarioRepository implements TipoExtraordinarioRepository
{

    protected $model;

    /**
     * EloquentTipoExtraordinarioRepository constructor.
     * @param TipoExtraordinario $model
     */
    public function __construct(TipoExtraordinario $model)
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