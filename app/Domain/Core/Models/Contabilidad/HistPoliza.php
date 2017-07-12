<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\User;
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
     * @param total
     * @return total con 2 decimales
     */
    public function getTotalAttribute($value) {
        return  $this->attributes['total'] = number_format((float)$value, 2, '.', '');
    }

    public function  getEstatusStringAttribute(){
        switch ($this->estatus){
            case 0:
                return "Registrada";
                break;
            case 1:
                return "Lanzada";
                break;
            case -1:
                return "No Lanzada";
                break;
            case -2:
                return "Con errores";
                break;
            default:
                break;
        }
    }
}