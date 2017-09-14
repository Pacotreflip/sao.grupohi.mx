<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Models\Concepto;

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
    public function __construct(Concepto $model)
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
    public function getBy($attribute, $operator, $value, $with = null)
    {
        if ($with != null)
            return $this->model->with($with)->where($attribute, $operator, $value)->get();
        return $this->model->where($attribute, $operator, $value)->limit(5)->get();
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


    /**
     * {@inheritdoc}
     */
    public function getDescendantsOf($id)
    {
        if (is_null($id)) {
            return $this->getRootLevels();
        }

        $concepto = $this->getById($id);

        return $this->model->where('nivel', 'like', $concepto->nivel_hijos)->get();

    }

    /**
     * {@inheritdoc}
     */
    public function getRootLevels()
    {
       // $idObra = $this->context->getId();

        return Concepto::whereRaw('LEN(nivel) = 4')
            ->orderBy('nivel')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        return Concepto::where('id_concepto', $id)
            ->firstOrFail();
    }
}