<?php

namespace Ghi\Domain\Core\Models;

use Carbon\Carbon;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
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
    protected $appends=['vigencia'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TransaccionInterfaz
     */
    public function transaccion() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_transaccion_interfaz');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|MovimientoPoliza
     */
    public function movimientos(){
        return $this->hasMany(MovimientoPoliza::class, "id_poliza_tipo");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function userAprobo() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function userCancelo() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return integer
     */
    public function getNumMovimientosAttribute() {
        return $this->movimientos->count();
    }

    /**
     * @return string
     */
    public function getVigenciaAttribute() {

        $actual = Carbon::now()->timestamp;
        if($this->inicio_vigencia->timestamp>$actual && ($this->fin_vigencia==null || $this->fin_vigencia->timestamp > $actual)){
            return "Pendiente";
        }
        if (!$this->fin_vigencia) {
             return $this->inicio_vigencia->timestamp <= $actual ? "Vigente" : "No Vigente";
        } else {
            return $this->inicio_vigencia->timestamp <= $actual && $this->fin_vigencia->timestamp >= $actual  ? "Vigente" : "No Vigente";
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVigentes($query) {
        return $query->whereNull('fin_vigencia')
            ->orWhere('fin_vigencia', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->orWhere('inicio_vigencia', '>=', DB::raw('CURRENT_TIMESTAMP'));
    }

    /**
     * @param integer $id_transaccion_interfaz
     * @return null|string
     */
    static public function fecha_minima($id_transaccion_interfaz) {
        $item = PolizaTipo::select(DB::raw("MAX(inicio_vigencia) as min_date"))->where('id_transaccion_interfaz','=', $id_transaccion_interfaz)->get();
        if (! $item[0]->min_date) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H', explode(" ", $item[0]->min_date)[0]. ' 00');
    }
}
