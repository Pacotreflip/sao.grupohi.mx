<?php

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistPoliza extends Model
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.hist_int_polizas';
    protected $primaryKey = 'id_hist_int_poliza';
    protected $fillable = [
        'id_int_poliza',
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
        'registro'
    ];

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
        return $this->hasMany(HistPolizaMovimiento::class, 'id_hist_int_poliza');
    }

    /**
     * @return User
     */
    public function user_registro()
    {
        return $this->belongsTo(User::class, 'registro', 'idusuario');
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
}