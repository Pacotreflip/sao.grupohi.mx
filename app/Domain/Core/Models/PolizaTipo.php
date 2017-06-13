<?php

namespace Ghi\Domain\Core\Models;

use Carbon\Carbon;
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
        'inicio_vigencia',
        'fin_vigencia'
    ];

    protected $dates = ['deleted_at', 'inicio_vigencia', 'fin_vigencia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaccionInterfaz() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_transaccion_interfaz');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientosPoliza(){
        return $this->hasMany(MovimientoPoliza::class, "id_poliza_tipo");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAprobo() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCancelo() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return mixed
     */
    public function getNumMovimientosAttribute() {
        return $this->movimientosPoliza->count();
    }

    /**
     * @return bool
     */
    public function getVigenteAttribute() {

        if(! $this->fin_vigencia) {
            return true;
        }

        return $this->fin_vigencia->lt(Carbon::now()->toDateTimeString());
    }
}
