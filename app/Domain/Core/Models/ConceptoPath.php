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
        'descripcion'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }
    public function getDescripcionAttribute() {
        return Concepto::find($this->id_concepto)->descripcion;
    }
}