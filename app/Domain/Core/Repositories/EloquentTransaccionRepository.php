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
        $items = $this->model->join('items', 'transacciones.id_transaccion', '=', 'items.id_transaccion')
            ->join('movimientos', 'items.id_item', '=', 'movimientos.id_item')->
            leftJoin('TipoTran', function($join)
            {
                $join->on('TipoTran.opciones', '=', DB::raw("transacciones.opciones AND  transacciones.tipo_transaccion = TipoTran.Tipo_Transaccion"));
            })
            ->selectRaw('TipoTran.descripcion as tipo_transaccion,
  count(transacciones.id_transaccion) as cantidad_transacciones,
    sum(movimientos.monto_total) as monto')
            ->where('movimientos.id_concepto', '=', $id_concepto)
            ->groupBy('TipoTran.descripcion')
            ->get();
        return $items;
    }

}