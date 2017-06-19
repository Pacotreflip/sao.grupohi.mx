<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCuentaContable extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|CuentaContable
     */
    public function cuentasContables() {
        return $this->hasMany(CuentaContable::class, 'id_cuenta_contable');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descripcion;
    }
}
