<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;
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
            return $this->model->with($with)->where($attribute, $operator, $value)->orderBy('nivel','asc')->get();
        return $this->model->where($attribute, $operator, $value)->orderBy('nivel','asc')->get();
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

    public function getInsumosPorTarjeta($id_tarjeta){
        $extraordinario = [];
        $concepto_precio_unitario = 0;

        $tarjeta = Tarjeta::find($id_tarjeta)->concepto_tarjeta()->get(['id_concepto'])->toArray();
        $conceptoTarjeta = Concepto::whereIn('id_concepto', $tarjeta)->where('cantidad_presupuestada', '>', 0)->first();
        $conceptos = $this->model->where('nivel', 'like', $conceptoTarjeta->nivel . '___.')->get();
        foreach ($conceptos as $concepto) {
            $insumos=$concepto->insumos()->get(['nivel', 'descripcion', 'unidad', 'id_material', 'cantidad_presupuestada', 'precio_unitario', 'monto_presupuestado'])->toArray();
            $agrupador_monto_presupuestado = 0;

            //// recalcular rendimiento de los insumos por agrupador
            foreach ($insumos as $key => $insumo){
                $insumos[$key]['cantidad_presupuestada'] = number_format($insumo['cantidad_presupuestada'] / $conceptoTarjeta->cantidad_presupuestada, 3, '.', '');
                $insumos[$key]['monto_presupuestado'] = number_format(($insumo['cantidad_presupuestada'] / $conceptoTarjeta->cantidad_presupuestada) * $insumo['precio_unitario'], 3, '.', '');
                $insumos[$key]['precio_unitario'] = number_format($insumo['precio_unitario'], 3, '.', '');
                $agrupador_monto_presupuestado += ($insumo['cantidad_presupuestada'] / $conceptoTarjeta->cantidad_presupuestada) * $insumo['precio_unitario'];
                $concepto_precio_unitario += ($insumo['cantidad_presupuestada'] / $conceptoTarjeta->cantidad_presupuestada) * $insumo['precio_unitario'];
            }
            //// ensambla el arreglo con los datos recabados de los insumos
            $extraordinario +=
            [str_replace(' ', '', $concepto->descripcion) =>
                [
                    'id_concepto' => $concepto->id_concepto,
                    'nivel' => $concepto->nivel,
                    'descripcion' => $concepto->descripcion,
                    'monto_presupuestado' => $agrupador_monto_presupuestado,
                    'insumos' => $insumos
                ]];
        }
        /// Ensamble final del arreglo
        $extraordinario +=
            [
                'id_concepto' =>$conceptoTarjeta->id_concepto,
                'nivel'=>$conceptoTarjeta->nivel,
                'descripcion'=>$conceptoTarjeta->descripcion,
                'unidad'=>$conceptoTarjeta->unidad,
                'id_material'=>$conceptoTarjeta->id_material,
                'cantidad_presupuestada'=>1,
                'precio_unitario'=>$concepto_precio_unitario,
                'monto_presupuestado'=>$concepto_precio_unitario
            ];

        return $extraordinario;
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


    /**
     * Guarda una nueva partida en el arbol de presupuesto
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function storePartida(array $data)
    {
        try{
            DB::connection('cadeco')->beginTransaction();
            $nivel_partida = 0;
            $descendientes = $this->model->where('nivel', 'like', $data['nivel'].'___.')->orderBy('nivel', 'asc')->get(['nivel']);
            if($descendientes->count() > 0) {
                for ($i = 1; $i <= $descendientes->count(); $i++) {
                    $nivel = explode('.', $descendientes[$i - 1]->nivel);
                    if (intval($nivel[sizeof($nivel) - 2]) != $i) {
                        $nivel_partida = $data['nivel'] . str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
                        break;
                    }else{
                        $nivel_partida = $data['nivel'] . str_pad($i+1, 3, '0', STR_PAD_LEFT) . '.';
                    }
                }

            }else{
                $nivel_partida = $data['nivel'] . str_pad(1, 3, '0', STR_PAD_LEFT) . '.';
            }
             $partida = Concepto::create(['nivel' => $nivel_partida , 'descripcion' => $data['descripcion'], 'unidad' => '']);

            DB::connection('cadeco')->commit();
            return Concepto::find($partida->id_concepto);
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }
}