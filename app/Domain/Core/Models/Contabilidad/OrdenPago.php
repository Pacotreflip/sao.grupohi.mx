<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 28/07/2017
 * Time: 11:36 AM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\OrdenPagoScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class OrdenPago extends Transaccion
{

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Orden de Pago
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrdenPagoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::ORDEN_PAGO;
            $model->opciones = 0;
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Factura
     */
    public function factura() {
        return $this->belongsTo(Factura::class, 'id_referente', 'id_transaccion');
    }
}