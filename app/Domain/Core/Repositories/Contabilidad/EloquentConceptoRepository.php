<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Support\Facades\DB;

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

        return $this->model ->orderBy('descripcion', 'desc')->where('nivel', 'like', $concepto->nivel_hijos)->get();

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

    public function obtenerMaxNumNiveles()
    {
        $item = $this->model->selectRaw('MAX(LEN(nivel)) / 4 as max_nivel')->first();

        return $item->max_nivel;
    }

    public function paths(array $data) {


        $query = DB::connection('cadeco')->table('conceptos')->where('conceptos.id_obra', '=', Context::getId())->join('PresupuestoObra.conceptosPath as path', 'conceptos.id_concepto', '=', 'path.id_concepto');

        if(array_key_exists('filtros', $data)) {
            foreach ($data['filtros'] as $key => $filtro) {
                $query->where(function ($q) use ($filtro) {
                    foreach ($filtro['operadores'] as $key => $operador) {
                        if($key == 0) {
                            $q->whereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'",$operador["sql"]));
                        } else {
                            $q->orWhereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'",$operador["sql"]));
                        }
                    }
                });

            }
        }

        $query->select(
            "conceptos.unidad",
            "conceptos.cantidad_presupuestada",
            "conceptos.precio_unitario",
            "conceptos.monto_presupuestado",
            DB::raw("(conceptos.cantidad_presupuestada * conceptos.precio_unitario) AS monto"),
            "path.*"
        );

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }
}