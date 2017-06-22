<?php

namespace Ghi;

use Ghi\Domain\Core\Models\CuentaContable;
use Ghi\Domain\Core\Models\TipoMovimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class polizasMovimientos extends Model
{    use SoftDeletes;
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_polizas_movimientos';
    protected $primaryKey = 'id_int_poliza_movimiento';
    protected $fillable = [
        'id_int_poliza',
        'id_tipo_cuenta_contable',
        'id_cuenta_contable',
        'cuenta_contable',
        'importe',
        'id_tipo_movimiento_poliza',
        'referencia',
        'concepto',
        'id_empresa_cadeco',
        'razon_social',
        'rfc',
        'estatus',
        'timestamp',
        'registro'
       ];

    public function polizasMovimientos() {
        return $this->belongsTo(Polizas::class, 'id_int_poliza');
    }
    public function cuentasContables() {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta_contable');
    }
    public function tiposMovimientos() {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento_poliza');
    }
}
