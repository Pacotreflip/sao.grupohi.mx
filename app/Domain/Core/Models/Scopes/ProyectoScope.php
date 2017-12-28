<?php

namespace Ghi\Domain\Core\Models\Scopes;

use Ghi\Core\Facades\Context;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProyectoScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->join('proyectos', 'Configuracion.cierres.id_proyecto', '=', 'proyectos.id')->where('proyectos.base_datos', '=', Context::getDatabaseName());
    }
}