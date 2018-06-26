<?php

namespace Ghi\Domain\Core\Models\Contabilidad;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Finanzas\Rubro;
use Ghi\Domain\Core\Models\Scopes\FacturaTransaccionScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class FacturaTransaccion extends Transaccion
{

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new FacturaTransaccionScope());
        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::FACTURA;
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
        });
    }

    public function rubros() {
        return $this->belongsToMany(Rubro::class, 'Finanzas.transacciones_rubros', 'id_transaccion', 'id_rubro');
    }

    public function contrarecibo() {
        return $this->belongsTo(Contrarecibo::class, 'id_antecedente');
    }
}