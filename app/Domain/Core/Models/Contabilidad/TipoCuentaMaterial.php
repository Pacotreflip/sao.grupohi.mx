<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCuentaMaterial extends Model
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.tipos_cuentas_materiales';
    protected $fillable = [
    'descripcion'
    ];

    public function __toString()
    {
        return $this->descripcion;
    }
}
