<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoPoliza extends Model
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.movimientos_poliza';
    protected $fillable = [
        'id_poliza_tipo',
        'id_cuenta_contable',
        'id_tipo_movimiento',
        'registro',
        'cancelo',
        'motivo'
    ];
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|PolizaTipo
     */
    public function polizaTipo() {
        return $this->belongsTo(PolizaTipo::class, 'id_poliza_tipo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoMovimiento
     */
    public function tipoMovimiento() {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|CuentaContable
     */
    public function cuentaContable() {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta_contable');
    }
}
