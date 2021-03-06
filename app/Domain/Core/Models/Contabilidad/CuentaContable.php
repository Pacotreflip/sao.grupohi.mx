<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\polizasMovimientos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaContable extends Model
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_cuentas_contables';
    protected $primaryKey = 'id_int_cuenta_contable';
    protected $fillable = [
        'id_obra',
        'id_int_tipo_cuenta_contable',
        'prefijo',
        'sufijo',
        'cuenta_contable',
        'estatus'
    ];
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraScope());
    }

    /**
     * CuentaContable constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes['id_obra'] = \Ghi\Core\Facades\Context::getId();
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoCuentaContable
     */
    public function tipoCuentaContable() {
        return $this->belongsTo(TipoCuentaContable::class, 'id_int_tipo_cuenta_contable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|MovimientoPoliza
     */
    public function movimientosPoliza() {
        return $this->hasMany(MovimientoPoliza::class, 'id_cuenta_contable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function polizaMovimientos() {
        return $this->hasMany(PolizaMovimiento::class, 'id_cuenta_contable');
    }


}