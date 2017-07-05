<?php

namespace Ghi\Domain\Core\Models\Scopes;

use Ghi\Equipamiento\Transacciones\Tipo;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RequisicionScope implements Scope
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
        return $builder->where('tipo_transaccion', '=', Tipo::REQUISICION)
            ->where('opciones', '=', 1);
    }
}