<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 14/06/2018
 * Time: 01:11 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Scopes\SolicitudPagoScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class SolicitudPago extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Solicitud de Pago
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SolicitudPagoScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::SOLICITUD_PAGO;
            $model->opciones = 327681;
            $model->id_moneda = Moneda::PESOS;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->id_obra = Context::getId();
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
            $model->saldo = $model->monto;
        });
    }

    public function antecedente() {
        return $this->belongsTo(Transaccion::class, 'id_antecedente');
    }
}