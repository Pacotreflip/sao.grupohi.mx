<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCuentaContable extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_tipos_cuentas_contables';
    protected $primaryKey = 'id_tipo_cuenta_contable';
    protected $fillable = [
        'descripcion',
        'estatus'
    ];

    public function cuentasContables() {
        return $this->hasMany(CuentaContable::class, 'id_cuenta_contable');
    }

    public function __toString()
    {
        return $this->descripcion;
    }
}
