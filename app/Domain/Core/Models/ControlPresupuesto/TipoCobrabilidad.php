<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoCobrabilidad extends Model
{
    protected $table = 'ControlPresupuesto.tipo_cobrabilidad';
    protected $connection = 'cadeco';
    protected $fillable = [
        'descripcion',
        'estatus'
    ];

}
