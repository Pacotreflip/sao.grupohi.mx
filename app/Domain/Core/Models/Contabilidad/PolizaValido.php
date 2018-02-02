<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaValido extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_polizas_valido';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_int_poliza',
        'valido',
    ];
}