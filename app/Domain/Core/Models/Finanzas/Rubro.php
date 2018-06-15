<?php

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubro extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Finanzas.rubros';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_tipo',
        'descripcion',
    ];

    protected static function boot()
    {
    }
}