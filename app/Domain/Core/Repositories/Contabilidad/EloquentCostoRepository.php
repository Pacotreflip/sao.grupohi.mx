<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CostoRepository;
use Ghi\Domain\Core\Models\Costo;

class EloquentCostoRepository implements CostoRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Costo
     */
    private $model;

    /**
     * EloquentCostoRepository constructor.
     * @param \Ghi\Domain\Core\Models\Costo $model
     */
    public function __construct(Costo $model)
    {
        $this->model = $model;
    }

    /**
     * Buscar Costos
     * @param $attribute
     * @param $operator
     * @param $value
     * @param null $with
     * @return Costo|\Illuminate\Database\Eloquent\Collection
     */
    public function getBy($attribute, $operator, $value, $with = null)
    {
        if ($with != null)
            return $this->model->with($with)->where($attribute, $operator, $value)->get();

        return $this->model->where($attribute, $operator, $value)->limit(5)->get();
    }

    /**
     * Obtiene un Costo que coincida con los parametros de búsqueda
     * @param $attribute
     * @param $value
     * @return \Illuminate\Database\Eloquent\Model|Costo
     */
    public function findBy($attribute, $value, $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->where($attribute, '=', $value)->first();
        }
        return $this->model->where($attribute, '=', $value)->first();
    }


    /**
     * {@inheritdoc}
     */
    public function getDescendantsOf($id)
    {
        if (is_null($id)) {
            return $this->getRootLevels();
        }

        $costo = $this->getById($id);

        return $this->model ->orderBy('descripcion', 'desc')->where('nivel', 'like', $costo->nivel_hijos)->get();

    }

    /**
     * {@inheritdoc}
     */
    public function getRootLevels()
    {
       // $idObra = $this->context->getId();

        return Costo::whereRaw('LEN(nivel) = 4')
            ->orderBy('nivel')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        return Costo::where('id_Costo', $id)
            ->firstOrFail();
    }
}