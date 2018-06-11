<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class CatalogoExtraordinarioPartidas extends Model
{
    protected $table = 'ControlPresupuesto.catalogo_extraordinarios_partidas';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'id_catalogo_extraordinarios',
        'nivel',
        'descripcion',
        'unidad',
        'id_material',
        'cantidad_presupuestada',
        'precio_unitario',
        'monto_presupuestado'
    ];

    public function insumos() {
        return $this->where('nivel', 'like', $this->nivel . '___.')->where('id_catalogo_extraordinarios', '=', $this->id);
    }
}
