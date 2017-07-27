<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Scopes\ObraCadecoScope;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poliza extends BaseModel
{
    use SoftDeletes;
    const NO_LANZADA = -2;
    const CON_ERRORES = -1;
    const NO_VALIDADA=0;
    const VALIDADA=1;
    const LANZADA = 2;


    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_polizas';
    protected $primaryKey = 'id_int_poliza';
    protected $fillable = [
        'id_tipo_poliza',
        'id_tipo_poliza_interfaz',
        'id_tipo_poliza_contpaq',
        'alias_bd_cadeco',
        'id_obra_cadeco',
        'id_transaccion_sao',
        'id_obra_contpaq',
        'alias_bd_contpaq',
        'fecha',
        'concepto',
        'total',
        'cuadre',
        'timestamp_registro',
        'estatus',
        'timestamp_lanzamiento',
        'usuario_lanzamiento',
        'id_poliza_contpaq',
        'poliza_contpaq',
        'registro',
        'lanzable',
        'fecha_original'
    ];

    protected $dates = ['fecha'];

    protected $appends = ['suma_debe', 'suma_haber'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraCadecoScope());

        static::creating(function ($model) {
            $model->id_obra_cadeco = Context::getId();
        });
    }

    public function estatusPrepoliza() {
        return $this->belongsTo(EstatusPrePoliza::class, 'estatus', 'estatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaccionInterfaz()
    {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_tipo_poliza_interfaz');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transacciones()
    {
        return $this->belongsTo(Transaccion::class, 'id_transaccion_sao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPolizaContpaq()
    {
        return $this->belongsTo(TipoPolizaContpaq::class, 'id_tipo_poliza_contpaq');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function polizaMovimientos()
    {
        return $this->hasMany(PolizaMovimiento::class, 'id_int_poliza')->orderBy('id_tipo_movimiento_poliza','asc')->orderBy('importe','desc');
    }

    /**
     * @return User
     */
    public function user_registro()
    {
        return $this->belongsTo(User::class, 'registro', 'idusuario');
    }
    /**
     * @return usuario registro
     */
    public function getUsuarioSolicitaAttribute()
    {
        $usuarioRegistro = substr($this->usuario_registro, 23, -1);
        return $usuarioRegistro;
    }
    /**
     * @return int
     */
    public function getSumaDebeAttribute()
    {
        $result = 0;
        foreach ($this->polizaMovimientos as $movimiento) {
            if ($movimiento->id_tipo_movimiento_poliza == 1) {
                $result += $movimiento->importe;
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getSumaHaberAttribute()
    {
        $result = 0;
        foreach ($this->polizaMovimientos as $movimiento) {
            if ($movimiento->id_tipo_movimiento_poliza == 2) {
                $result += $movimiento->importe;
            }
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getCuadradoAttribute()
    {
        if(abs(abs($this->SumaHaber)-$this->total)>0.1||abs(abs($this->SumaDebe)-$this->total)>0.1){
            return false;
        }
        return true;
    }

    public function historicos() {
        return $this->hasMany(HistPoliza::class, 'id_int_poliza', 'id_int_poliza');
    }
    public  function scopeConErrores($query){
        return $query->where('Contabilidad.int_polizas.estatus', '=', static::CON_ERRORES);
    }
}