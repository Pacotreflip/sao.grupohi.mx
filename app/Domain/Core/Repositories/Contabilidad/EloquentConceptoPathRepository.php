<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Models\ConceptoPath;
use Illuminate\Support\Facades\DB;

class EloquentConceptoPathRepository implements ConceptoPathRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Concepto
     */
    private $model;

    /**
     * EloquentConceptoPathRepository constructor.
     * @param \Ghi\Domain\Core\Models\ConceptoPath $model
     */
    public function __construct(ConceptoPath $model)
    {
        $this->model = $model;
    }

    public function buscarCostoTotal($raw)
    {
        $items = $this->model->leftJoin('movimientos', 'movimientos.id_concepto', '=', 'conceptosPath.id_concepto')
            ->selectRaw('sum(movimientos.monto_total) as total, conceptosPath.id_concepto, conceptosPath.nivel')
            ->whereRaw($raw)
            ->groupBy(DB::raw('conceptosPath.id_concepto, conceptosPath.nivel'))
            ->havingRaw('sum(movimientos.monto_total) > 0')
            ->get();

        return $items;
    }
}