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

    public function polizaTipo() {
        return $this->belongsTo(PolizaTipo::class, 'id_poliza_tipo');
    }
    public function tipoMovimiento() {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento');
    }
    public function cuentaContable() {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta_contable');
    }

}
