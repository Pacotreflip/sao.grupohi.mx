<?php

namespace Ghi\Domain\Core\Models\Finanzas;

use Ghi\Domain\Core\Models\Fondo;
use Ghi\Domain\Core\Models\Scopes\ComprobanteFondoFijoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class ComprobanteFondoFijo extends Transaccion
{

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Comprobante de Fondo Fijo
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ComprobanteFondoFijoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::COMPROBANTE_FONDO_FIJO;
            $model->opciones = 1;
            $model->id_obra = Context::getId();
        });
    }

    public function items()
    {
        return $this->belongsTo(Item::class, "id_transaccion", "id_transaccion");
    }

    public function fondoFijo(){
        return $this->belongsTo(Fondo::class,"id_referente","id_fondo");
    }
}