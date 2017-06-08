<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaTipo extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'poliza_tipo';
    protected $fillable = [
        'id_transaccion_interfaz',
        'registro',
        'aprobo',
        'cancelo',
        'motivo',
        'estatus'
    ];

    public function transaccionInterfaz() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_transaccion_interfaz');
    }
    public function movimientosPoliza(){
        return $this->hasMany(MovimientoPoliza::class, "id_poliza_tipo");
    }
}
