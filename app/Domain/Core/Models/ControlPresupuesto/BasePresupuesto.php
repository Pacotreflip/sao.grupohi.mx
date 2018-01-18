<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class BasePresupuesto extends Model
{
    protected $table = 'ControlPresupuesto.bases_presupuesto';
    protected $connection = 'cadeco';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descripcion',
        'base_datos'
    ];

}
