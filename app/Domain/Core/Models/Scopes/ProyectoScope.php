<?php

namespace Ghi\Domain\Core\Models\Scopes;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
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
        $proyecto = Proyecto::where('base_datos', '=', Context::getDatabaseName())->first();
        return $builder->where($model->getTable().'.id_proyecto', '=', $proyecto->id);
    }
}