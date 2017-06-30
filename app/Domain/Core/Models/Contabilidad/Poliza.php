<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poliza extends BaseModel
{
    use SoftDeletes;

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
        'registro'
    ];

    protected $appends = ['suma_debe', 'suma_haber'];

    /**
     * Poliza constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes['id_obra_cadeco'] = \Ghi\Core\Facades\Context::getId();
        parent::__construct($attributes);
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
        return $this->hasMany(PolizaMovimiento::class, 'id_int_poliza');
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
        if(abs($this->SumaHaber-$this->total)>0.1||abs($this->SumaDebe-$this->total)>0.1){
            return false;
        }
        return true;
    }

    public function __toString()
    {
        return (String) $this->tipoPolizaContpaq;
    }
}