<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;


class CuentaContable extends Model
{
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
    public function obra() {
        return $this->belongsTo(Obra::class, 'id_obra');
    }
    public function tipoCuentaContable() {
        return $this->belongsTo(TipoCuentaContable::class, 'id_int_tipo_cuenta_contable');
    }

    public function movimientosPoliza() {
        return $this->hasMany(MovimientoPoliza::class, 'id_cuenta_contable');
    }

}
