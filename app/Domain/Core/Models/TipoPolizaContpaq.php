<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPolizaContpaq extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_tipos_polizas_contpaq';
    protected $primaryKey = 'id_int_tipo_poliza_contpaq';
    protected $fillable = [
        'descripcion',
        'estatus',
        'id_int_tipo_poliza_contpaq'
    ];
}
