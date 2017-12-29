<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
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
    public function __construct(ConceptoPath $model, ConceptoRepository $concepto)
    {
        $this->model = $model;
        $this->concepto = $concepto;
    }

    public function filtrarConMovimiento($raw)
    {
        $maxNivel = $this->concepto->obtenerMaxNumNiveles();
        $string = '';

        for ($i = 1; $i <= $maxNivel; $i++) {
            $string .= 'filtro'. $i .',';
        }

        $items = $this->model->leftJoin('movimientos', 'movimientos.id_concepto', '=', 'conceptosPath.id_concepto')
            ->selectRaw($string .'sum(movimientos.monto_total) as total, conceptosPath.id_concepto, conceptosPath.nivel')
            ->whereRaw($raw)
            ->groupBy(DB::raw($string .'conceptosPath.id_concepto, conceptosPath.nivel'))
            ->havingRaw('sum(movimientos.monto_total) > 0')
            ->get();

        return $items;
    }

    public function filtrar($raw)
    {
        $maxNivel = $this->concepto->obtenerMaxNumNiveles();
        $string = '';

        for ($i = 1; $i <= $maxNivel; $i++)
            $string .= 'filtro'. $i .',';

        $items = $this->model->selectRaw($string .' conceptosPath.id_concepto, conceptosPath.nivel')
            ->whereRaw($raw)
            ->groupBy(DB::raw($string .'conceptosPath.id_concepto, conceptosPath.nivel'))
            ->get();

        return $items;
    }
}