<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\Concepto;
use Ghi\Domain\Core\Contracts\ConceptoRepository;
use Ghi\Domain\Core\Models\Obra;


class EloquentConceptoRepository implements ConceptoRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Concepto
     */
    private $model;

    /**
     * EloquentConceptoRepository constructor.
     * @param \Ghi\Domain\Core\Models\Concepto $model
     */
    public function __construct(Obra $model)
    {
        $this->model = $model;
    }

    /**
     * Buscar conceptos
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Concepto
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
    }

    /**
     * Obtiene un Concepto que coincida con los parametros de búsqueda
     * @param $attribute
     * @param $value
     * @return \Illuminate\Database\Eloquent\Model|Concepto
     */
    public function findBy($attribute, $value, $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->where($attribute, '=', $value)->first();
        }
        return $this->model->where($attribute, '=', $value)->first();
    }
}