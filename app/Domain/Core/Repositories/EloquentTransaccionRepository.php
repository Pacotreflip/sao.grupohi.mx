<?php

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Contracts\TransaccionRepository;
use Ghi\Domain\Core\Models\Items;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Support\Facades\DB;

class EloquentTransaccionRepository implements TransaccionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Material
     */
    protected $model;
    /**
     * @var Items
     */
    private $items;

    /**
     * EloquentMaterialRepository constructor.
     * @param \Ghi\Domain\Core\Models\Material|Transaccion $model
     * @param Items $items
     */
    public function __construct(Transaccion $model, Items $items)
    {
        $this->model = $model;
        $this->items = $items;
    }

    /**
     * @param $id_concepto
     * @return mixed
     */
    public function tiposTransaccion($id_concepto)
    {
        // Trabaja con arrays
        $id_concepto = (array) $id_concepto;

        return $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  TipoTran.Tipo_Transaccion = transacciones.tipo_transaccion"));
            })
            ->selectRaw('TipoTran.descripcion as descripcion,
   COUNT( DISTINCT transacciones.id_transaccion) as cantidad,
    sum(movimientos.monto_total) as monto, transacciones.opciones')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->groupBy(DB::raw('TipoTran.descripcion, transacciones.opciones'))
            ->get();
    }

    /**
     * @param $id_concepto
     * @return mixed
     */
    public function detallesTransacciones($id_concepto)
    {
        // Trabaja con arrays
        $id_concepto = (array) $id_concepto;

        $items = $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  TipoTran.Tipo_Transaccion = transacciones.tipo_transaccion"));
            })
            ->selectRaw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,
 fecha, numero_folio, transacciones.id_transaccion,
sum(movimientos.monto_total) as monto')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->groupBy(DB::raw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,fecha, numero_folio, transacciones.id_transaccion'))
            ->get();

        return $items;
    }

    /**
     * @param $id_transaccion
     * @return mixed
     */
    public function items($id_transaccion)
    {
        return $this->items->where('items.id_transaccion', '=', $id_transaccion)
            ->leftJoin('transacciones', 'transacciones.id_transaccion', '=', DB::raw($id_transaccion))
            ->leftJoin('materiales', 'materiales.id_material', '=', 'items.id_material')
            ->leftJoin('conceptos', 'conceptos.id_concepto', '=', 'items.id_concepto')
            ->selectRaw('transacciones.observaciones, items.cantidad, items.precio_unitario, items.importe, items.id_concepto, materiales.descripcion, items.id_item, conceptos.descripcion as concepto_descripcion')
            ->get();
    }

    public function selectTipos()
    {
        return $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  TipoTran.Tipo_Transaccion = transacciones.tipo_transaccion"));
            })
            ->selectRaw('transacciones.tipo_transaccion,TipoTran.descripcion as descripcion,
 transacciones.opciones')
            ->groupBy(DB::raw('transacciones.tipo_transaccion,TipoTran.descripcion, transacciones.opciones'))
            ->get();
    }

    public function filtrarTipos($where)
    {
        $string = 'transacciones.tipo_transaccion = '. $where['tipo'] .' and transacciones.opciones = '. $where['opciones'];

        if (isset($where['folio']))
            $string .= ' and transacciones.numero_folio = '. $where['folio'];

        $items = $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  TipoTran.Tipo_Transaccion = transacciones.tipo_transaccion"));
            })
            ->selectRaw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,
 fecha, numero_folio, transacciones.id_transaccion,
sum(movimientos.monto_total) as monto')
            ->whereRaw($string)
            ->groupBy(DB::raw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,fecha, numero_folio, transacciones.id_transaccion'))
            ->get();

        return $items;
    }

    public function filtrarTiposTransaccion($where)
    {
        $string = 'transacciones.tipo_transaccion = '. $where['tipo'] .' and transacciones.opciones = '. $where['opciones'];

        if (isset($where['folio']))
            $string .= ' and transacciones.numero_folio = '. $where['folio'];

        return $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  TipoTran.Tipo_Transaccion = transacciones.tipo_transaccion"));
            })
            ->selectRaw('TipoTran.descripcion as descripcion,
   COUNT( DISTINCT transacciones.id_transaccion) as cantidad,
    sum(movimientos.monto_total) as monto, transacciones.opciones')
            ->whereRaw($string)
            ->groupBy(DB::raw('TipoTran.descripcion, transacciones.opciones'))
            ->get();
    }
}