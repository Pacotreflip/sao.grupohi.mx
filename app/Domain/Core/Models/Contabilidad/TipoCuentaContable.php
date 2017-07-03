<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCuentaContable extends Model
{
    const TIPO_GENERALES = 1;

    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_tipos_cuentas_contables';
    protected $primaryKey = 'id_tipo_cuenta_contable';
    protected $fillable = [
        'descripcion',
        'estatus',
        'registro',
        'id_obra',
        'motivo'
    ];
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|CuentaContable
     */
    public function cuentaContable() {
        return $this->hasOne(CuentaContable::class, 'id_int_tipo_cuenta_contable');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descripcion;
    }

    public function scopeGenerales($query) {
        return $query->where('Contabilidad.int_tipos_cuentas_contables.tipo', '=', $this::TIPO_GENERALES);
    }
}
