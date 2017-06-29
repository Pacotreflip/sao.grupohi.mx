<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class CuentaAlmacen extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_almacenes';
    protected $primaryKey = 'id';
}
