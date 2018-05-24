<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoExtraordinario extends Model
{

    protected $table = 'ControlPresupuesto.tipos_extraordinarios';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'descripcion'
    ];
}
