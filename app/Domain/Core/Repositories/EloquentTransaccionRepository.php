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
     * @var \Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    protected $model;
    /**
     * @var Items
     */
    private $items;

    /**
     * EloquentTransaccionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Material|Transaccion $model
     * @param Items $items
     */
    public function __construct(Transaccion $model, Items $items)
    {
        $this->model = $model;
        $this->items = $items;
    }

    public function tiposTransaccion($id_concepto)
    {
        // Trabaja con arrays
        $id_concepto = (array) $id_concepto;

        return $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  transacciones.tipo_transaccion LIKE '%TipoTran.Tipo_Transaccion%'"));
            })
            ->selectRaw('TipoTran.descripcion as tipo_transaccion,
   COUNT( DISTINCT transacciones.id_transaccion) as cantidad,
    sum(movimientos.monto_total) as monto, transacciones.opciones')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->groupBy(DB::raw('TipoTran.descripcion, transacciones.opciones'))
            ->get();
    }

    public function detallesTransacciones($id_concepto)
    {
        // Trabaja con arrays
        $id_concepto = (array) $id_concepto;

        $items = $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  transacciones.tipo_transaccion LIKE '%TipoTran.Tipo_Transaccion%'"));
            })
            ->selectRaw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,
 fecha, numero_folio, transacciones.id_transaccion,
sum(movimientos.monto_total) as monto')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->groupBy(DB::raw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,fecha, numero_folio, transacciones.id_transaccion'))
            ->get();

        return $items;
    }

    public function items($id_transaccion)
    {
        return $this->items->where('items.id_transaccion', '=', $id_transaccion)
            ->leftJoin('transacciones', 'transacciones.id_transaccion', '=', DB::raw($id_transaccion))
            ->leftJoin('materiales', 'materiales.id_material', '=', 'items.id_material')
            ->leftJoin('conceptos', 'conceptos.id_concepto', '=', 'items.id_concepto')
            ->selectRaw('transacciones.observaciones, items.cantidad, items.precio_unitario, items.importe, items.id_concepto, materiales.descripcion, items.id_item, conceptos.descripcion as concepto_descripcion')
            ->get();
    }
}