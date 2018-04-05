<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoFiltro extends Model
{
    const SECTOR = 1;
    const CUADRANTE = 2;
    const TARJETA = 3;

    protected $table = 'ControlPresupuesto.tipo_filtro';
    protected $connection = 'cadeco';
    public $timestamps = false;
    protected $fillable = [
        'descripcion',
        'id'
    ];

}
