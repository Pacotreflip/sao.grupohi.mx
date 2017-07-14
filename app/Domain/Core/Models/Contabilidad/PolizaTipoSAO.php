<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaTipoSAO extends BaseModel
{
    use SoftDeletes;

    var $id_obra;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.poliza_tipo_sao';
    protected $fillable = [
        'descripcion',
        'estatus',
        'id_obra'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function($model) {
            $model->id_obra = Context::getId();
        });
    }

    public function __toString()
    {
        return $this->descripcion;
    }
}
