<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Support\Facades\DB;

class ConceptoPath extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'PresupuestoObra.conceptosPath';
    protected $primaryKey = 'id_concepto';
    protected $appends = [
        'id_obra',
        'id_concepto',
        'nivel',
        'filtro1',
        'filtro2',
        'filtro3',
        'filtro4',
        'filtro5',
        'filtro6',
        'filtro7',
        'filtro8',
        'filtro9',
        'filtro10',
        'filtro11',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }
}