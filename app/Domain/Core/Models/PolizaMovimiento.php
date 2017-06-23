<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaMovimiento extends Model
{
    use SoftDeletes;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function polizaMovimiento() {
        return $this->belongsTo(Poliza::class, 'id_int_poliza');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cuentaContable() {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta_contable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoMovimientos() {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento_poliza');
    }

    public function getDescripcionCuentaContableAttribute(){
        if ($cuenta_contable = CuentaContable::where('cuenta_contable', '=', $this->cuenta_contable)->first()) {
            return (String) $cuenta_contable->tipoCuentaContable;
        } else {
            return "No Registrada";
        }
    }

}
