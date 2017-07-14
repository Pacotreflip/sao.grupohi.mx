<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAORepository;
use Ghi\Domain\Core\Models\Contabilidad\PolizaTipoSAO;

class EloquentPolizaTipoSAORepository implements PolizaTipoSAORepository
{
    /**
     * @var PolizaTipoSAO $model
     */
    private $model;

    /**
     * EloquentPolizaTipoSAORepository constructor.
     * @param PolizaTipoSAO $model
     */
    public function __construct(PolizaTipoSAO $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene un elemento por id
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\PolizaTipoSAO
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAO
     */
    public function all()
    {
        return $this->get();
    }

    /**
     * Obtiene todas las elementos en forma de lista
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAO
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
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