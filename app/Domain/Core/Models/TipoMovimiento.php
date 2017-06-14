<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.tipos_movimientos';
    protected $fillable = [
        'descripcion'
    ];
    public function movimientosPoliza() {
        return $this->hasMany(MovimientoPoliza::class, 'id_tipo_movimiento');
    }

}
