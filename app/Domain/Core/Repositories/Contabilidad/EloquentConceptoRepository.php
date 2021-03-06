<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

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

        return $this->model->orderBy('descripcion', 'desc')->where('nivel', 'like', $concepto->nivel_hijos)->get();

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

    public function paths(array $data, $baseDatos = null)
    {
        $db = $baseDatos == null ? Context::getDatabaseName() : $baseDatos;

        $query = DB::connection('cadeco')->table($db . '.dbo.conceptos')->where('conceptos.id_obra', '=', Context::getId())->join($db . '.PresupuestoObra.conceptosPath as path', 'conceptos.id_concepto', '=', 'path.id_concepto');

        if (array_key_exists('filtros', $data)) {
            foreach ($data['filtros'] as $key => $filtro) {
                $query->where(function ($q) use ($filtro) {
                    foreach ($filtro['operadores'] as $key => $operador) {
                        if ($key == 0) {
                            $q->whereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'", $operador["sql"]));
                        } else {
                            $q->orWhereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'", $operador["sql"]));
                        }
                    }
                });

            }
        }
        $query->orderBy('conceptos.nivel');
        $query->select(
            "conceptos.unidad",
            "conceptos.cantidad_presupuestada",
            "conceptos.precio_unitario",
            "conceptos.monto_presupuestado as monto",
            "path.*"
        );

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    public function pathsConceptos(array $data)
    {

        $query = DB::connection('cadeco')->table('dbo.conceptos')->where('conceptos.id_obra', '=', Context::getId())
            ->join('PresupuestoObra.conceptosPath as path', 'conceptos.id_concepto', '=', 'path.id_concepto');

        $query->where('dbo.conceptos.concepto_medible', '=', 3);
        $query->where('dbo.conceptos.activo', '=', 1);
        $query->where('monto_presupuestado', '!=', 0);
        $query->where('cantidad_presupuestada', '!=', 0);

        $query->where('path.filtro3', 'Like', '%COSTO DIRECTO%');


        $query->join('ControlPresupuesto.concepto_tarjeta', 'dbo.conceptos.id_concepto', '=', 'ControlPresupuesto.concepto_tarjeta.id_concepto')
            ->join('ControlPresupuesto.tarjeta', 'ControlPresupuesto.concepto_tarjeta.id_tarjeta', '=', 'ControlPresupuesto.tarjeta.id')
            ->where('ControlPresupuesto.tarjeta.id', '=', $data['id_tarjeta'] == '' ? null : $data['id_tarjeta']);


        if (isset($data['order'])) {
            foreach ($data['order'] as $order) {
                $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
            }
        }
        $query->orderBy('conceptos.nivel');

        if (array_key_exists('filtros', $data)) {
            foreach ($data['filtros'] as $key => $filtro) {
                $query->where(function ($q) use ($filtro) {
                    foreach ($filtro['operadores'] as $key => $operador) {
                        if ($key == 0) {
                            $q->whereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'", $operador["sql"]));
                        } else {
                            $q->orWhereRaw('filtro' . $filtro['nivel'] . ' ' . str_replace('"', "'", $operador["sql"]));
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
            "path.*"
        );

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);

    }

    public function pathsCostoIndirecto(array $data)
    {
        $conceptos = $this->model->select(
            "conceptos.unidad",
            "conceptos.cantidad_presupuestada",
            "conceptos.precio_unitario",
            "conceptos.monto_presupuestado",
            "path.*"
        )
            ->where('dbo.conceptos.activo', '=', 1)
            ->where('dbo.conceptos.concepto_medible', '=', 3)
            ->join('PresupuestoObra.conceptosPath as path', 'conceptos.id_concepto', '=', 'path.id_concepto')
            ->where('path.filtro3', 'Like', '%COSTO INDIRECTO%')
            ->where(function ($q) use ($data) {
                $q->where('path.filtro5', 'Like', '%' . $data['descripcion'] . '%')
                    ->orWhere('path.filtro6', 'Like', '%' . $data['descripcion'] . '%')
                    ->orWhere('path.filtro7', 'Like', '%' . $data['descripcion'] . '%');
            })->limit(5)
            ->get();
        //dd($conceptos);
        return $conceptos;

    }

    /**
     * Obtiene los insumos de un concepto medible
     * @param $id
     * @return mixed
     */
    public function getInsumos($id)
    {

        $cobrable = $this->model->where('id_concepto', $id)->first();
        $conceptos = $this->model->where('nivel', 'like', $cobrable->nivel . '___.')->get();
        $data = [];
        foreach ($conceptos as $concepto) {

            $data[str_replace(' ', '', $concepto->descripcion)] =
                [
                    'id_concepto' => $concepto->id_concepto,
                    'nivel' => $concepto->nivel,
                    'descripcion' => $concepto->descripcion,
                    'monto_presupuestado' => $concepto->monto_presupuestado,
                    'insumos' => Concepto::where('nivel', 'like', $concepto->nivel . '___.')->get()->toArray()
                ];

        }
        $cob_conceptos = [
            'cobrable' => $cobrable->toArray(),
            'conceptos' => $data
        ];


        return $cob_conceptos;
    }

    public function getPreciosConceptos($id)
    {
        $precios = $this->model->select(
            DB::raw('count(conceptos.id_material) as cantidad, conceptos.id_material, conceptos.descripcion,conceptos.precio_unitario')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'conceptos.id_concepto', '=', 'ct.id_concepto')
            ->join('ControlPresupuesto.tarjeta as t ', 't.id', '=', 'ct.id_tarjeta')
            ->where('id_material', '=', $id)
            ->groupBy('conceptos.precio_unitario', 'conceptos.descripcion', 'conceptos.id_material')
            ->orderBy('conceptos.precio_unitario', 'asc')
            ->get();
        $lista_precios = [];
        foreach ($precios as $precio) {
            array_push($lista_precios, $precio->precio_unitario);
        }
        return $lista_precios;

    }


}