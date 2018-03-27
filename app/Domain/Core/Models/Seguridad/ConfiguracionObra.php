<?php

namespace Ghi\Domain\Core\Models\Seguridad;

use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\ProyectoScope;
use Illuminate\Database\Eloquent\Model;
use Ghi\Core\Facades\Context;

/**
 * Class ConfiguracionObra
 * @package Ghi\Domain\Core\Models\Seguridad
 */
class ConfiguracionObra extends Model
{
    /**
     * @var string table connection
     */
    protected $connection = 'seguridad';
    /**
     * @var string name table
     */
    protected $table = 'dbo.configuracion_obra';

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
        , 'logotipo_reportes'
        , 'logotipo_original'
        , 'vigencia'
    ];
}
