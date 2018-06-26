<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\Scopes\FacturaMaterialesServiciosScope;

class FacturaMaterialesServicios extends FacturaTransaccion
{

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura de Varios Materiales / Servicios
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new FacturaMaterialesServiciosScope());

        static::creating(function ($model) {
            $model->opciones = 65537;
        });
    }
}