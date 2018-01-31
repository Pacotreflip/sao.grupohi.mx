<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    const ESCALATORIA = 1;
    const RECLAMOS_INDIRECTO = 2;
    const CONCEPTOS_EXTRAORDINARIOS = 3;
    const VARIACION_VOLUMEN = 4;
    const ORDEN_DE_CAMBIO_NO_COBRABLE = 5;
    const ORDEN_DE_CAMBIO_DE_INSUMOS = 6;

    protected $table = 'ControlPresupuesto.tipos_ordenes';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'descripcion',
        'id_tipo_cobrabilidad',
        'estatus'
    ];

    public function cobrabilidad()
    {
        return $this->belongsTo(TipoCobrabilidad::class, 'id_tipo_cobrabilidad', 'id');
    }
}
