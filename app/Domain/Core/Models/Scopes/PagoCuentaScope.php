<?php

namespace Ghi\Domain\Core\Models\Scopes;

use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PagoCuentaScope implements Scope
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
        return $builder
            ->where('tipo_transaccion', '=', Tipo::PAGO_A_CUENTA)
            ->where('opciones', '=', 327681);
    }
}