<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class CuentaAlmacen extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_almacenes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_almacen',
        'cuenta',
        'registro',
        'estatus'
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['estatus'] = 1;
        parent::__construct($attributes);
    }
}
