<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\Scopes\FacturaGastosVariosScope;


class FacturaGastosVarios extends FacturaTransaccion
{

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura de Gastos Varios
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new FacturaGastosVariosScope());

        static::creating(function ($model) {
            $model->opciones = 1;
        });
    }
}