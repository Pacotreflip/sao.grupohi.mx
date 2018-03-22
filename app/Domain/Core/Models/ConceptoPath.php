<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Support\Facades\DB;

class ConceptoPath extends BaseModel
{
    const COLUMN_SECTOR = "cp.filtro4";
    const COLUMN_CUADRANTE = "cp.filtro5";


    protected $connection = 'cadeco';
    protected $table = 'PresupuestoObra.conceptosPath';
    protected $primaryKey = 'id_concepto';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }
    public $timestamps = false;
    protected $fillable = [
        'id_obra'
        , 'id_concepto'
        , 'nivel'
        , 'filtro1'
        , 'filtro2'
        , 'filtro3'
        , 'filtro4'
        , 'filtro5'
        , 'filtro6'
        , 'filtro7'
        , 'filtro8'
        , 'filtro9'
        , 'filtro10'
        , 'filtro11'

    ];

    public function getInsumosPorTarjeta($id){
        $this->join('dbo.conceptos c', 'c.id_concepto', '=', $this->id_concepto)
            ->join('ControlPresupuesto.concepto_tarjeta ct', 'ct.id_concepto',  '=',  'c.id_concepto')
            ->join('ControlPresupuesto.tarjeta t', 't.id', '=', 'ct.id_tarjeta')
            ->where('c.id_material', '=', $id)
            ->orderBy('cp.filtro5', 'desc')->get();
    }
}