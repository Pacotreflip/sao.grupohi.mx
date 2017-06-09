<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaTipo extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function transaccionInterfaz() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_transaccion_interfaz');
    }
    public function movimientosPoliza(){
        return $this->hasMany(MovimientoPoliza::class, "id_poliza_tipo");
    }
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }
    public function userAprobo() {
        return $this->belongsTo(User::class, 'registro');
    }
    public function userCancelo() {
        return $this->belongsTo(User::class, 'registro');
    }
    public function getNumMovimientosAttribute() {
        return $this->movimientosPoliza->count();
    }
}
