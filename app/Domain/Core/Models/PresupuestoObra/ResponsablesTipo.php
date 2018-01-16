<?php

namespace Ghi\Domain\Core\Models\PresupuestoObra;

use Ghi\Domain\Core\Models\BaseModel;

class ResponsablesTipo extends BaseModel
{
    public $timestamps = false;
    protected $connection = 'cadeco';
    protected $table = 'PresupuestoObra.responsables_tipo';
    protected $primaryKey = 'tipo';
    protected $fillable = [
        'descripcion',
    ];

    protected static function boot()
    {
        parent::boot();
    }
}
