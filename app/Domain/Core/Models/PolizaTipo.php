<?php

namespace Ghi\Domain\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PolizaTipo extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.poliza_tipo';
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
    public function transaccion() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_transaccion_interfaz');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientos(){
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
        return $this->movimientos->count();
    }

    /**
     * @return bool
     */
    public function getVigenteAttribute() {
        $actual = Carbon::now()->timestamp;
        if (! $this->fin_vigencia) {
             return $this->inicio_vigencia->timestamp <= $actual;
        } else {
            return $this->inicio_vigencia->timestamp <= $actual && $this->fin_vigencia->timestamp >= $actual;
        }
    }

    public function scopeVigentes($query) {
        return $query->whereNull('fin_vigencia')
            ->orWhere('fin_vigencia', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->orWhere('inicio_vigencia', '>=', DB::raw('CURRENT_TIMESTAMP'));
    }

    public function getMinDateAttribute() {
        $item = $this->select(DB::raw("MAX(inicio_vigencia) as fecha_minima"))->where('id_transaccion_interfaz','=',$this->id_transaccion_interfaz)->limit(1)->get();
        return explode(" ", $item[0]->fecha_minima)[0];
    }
}
