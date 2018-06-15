<?php

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoRubro extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Finanzas.tipos_rubros';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descripcion',
    ];

    protected static function boot()
    {
    }
}