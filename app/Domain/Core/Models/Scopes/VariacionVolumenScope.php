<?php

namespace Ghi\Domain\Core\Models\Scopes;

use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VariacionVolumenScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('id_tipo_orden', '=', TipoOrden::VARIACION_VOLUMEN);
    }
}