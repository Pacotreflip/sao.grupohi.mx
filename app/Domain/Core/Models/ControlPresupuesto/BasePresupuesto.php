<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class BasePresupuesto extends Model
{
    protected $table = 'ControlPresupuesto.bases_presupuesto';
    protected $connection = 'cadeco';
    protected $fillable = [
        'descripcion',
        'base_datos'
    ];

    public function tiposOrden() {
        return $this->belongsToMany(TipoOrden::class, 'ControlPresupuesto.afectacion_ordenes_presupuesto', 'id_base_presupuesto', 'id_tipo_orden');
    }
}
