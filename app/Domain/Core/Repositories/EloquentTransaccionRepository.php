<?php

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Contracts\TransaccionRepository;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Support\Facades\DB;

class EloquentTransaccionRepository implements TransaccionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Material
     */
    protected $model;

    /**
     * EloquentMaterialRepository constructor.
     * @param \Ghi\Domain\Core\Models\Material $model
     */
    public function __construct(Transaccion $model)
    {
        $this->model = $model;
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
movimientos.monto_total as monto, fecha, numero_folio ')
            ->whereIn('movimientos.id_concepto', $id_concepto)
            ->get();

        return $items;
    }
}