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

    public function tiposTransaccion($id_concepto)
    {
        // Trabaja con arrays
        $id_concepto = (array) $id_concepto;

        return $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  transacciones.tipo_transaccion = TipoTran.Tipo_Transaccion"));
            })
            ->selectRaw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,
sum(movimientos.monto_total) as monto, count(transacciones.id_transaccion) as cantidad')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->groupBy(DB::raw('transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion, movimientos.id_concepto'))
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
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  transacciones.tipo_transaccion = TipoTran.Tipo_Transaccion"));
            })
            ->selectRaw('movimientos.id_concepto, transacciones.tipo_transaccion, transacciones.opciones, TipoTran.descripcion,
movimientos.monto_total as monto, fecha, numero_folio, transacciones.id_transaccion')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->get();

        return $items;
    }

    public function items($id_transaccion)
    {
        return $this->items->where('id_transaccion', '=', $id_transaccion)
            ->join('conceptos', 'conceptos.id_concepto', '=', 'items.id_concepto')
            ->selectRaw('conceptos.descripcion, items.cantidad, items.precio_unitario, items.importe, items.id_concepto')
            ->get();
    }
}