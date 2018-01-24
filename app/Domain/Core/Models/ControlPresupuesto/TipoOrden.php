<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    protected $table = 'ControlPresupuesto.tipos_ordenes';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'descripcion',
        'id_tipo_cobrabilidad',
        'estatus'
    ];

}
