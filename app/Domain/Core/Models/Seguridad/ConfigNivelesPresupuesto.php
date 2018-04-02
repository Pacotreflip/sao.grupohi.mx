<?php

namespace Ghi\Domain\Core\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\ProyectoScope;
use Ghi\Core\Facades\Context;

/**
 * Class ConfigNivelesPresupuesto
 * @package Ghi\Domain\Core\Models
 */
class ConfigNivelesPresupuesto extends Model
{
    /**
     * @var string table connection
     */
    protected $connection = 'seguridad';
    /**
     * @var string name table
     */
    protected $table = 'dbo.config_niveles_presupuesto';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
        static::addGlobalScope(new ProyectoScope());
        static::creating(function ($model) {
            $model->id_user =  auth()->id();
            $model->id_proyecto = Proyecto::where('base_datos', '=',Context::getDatabaseName())->first()->id;
            $model->id_obra = Context::getId();
        });
    }

    /**
     * @var array
     */
    protected $fillable = [
        'id'
        , 'order_by'
        , 'name_column'
        , 'description'
    ];
}
