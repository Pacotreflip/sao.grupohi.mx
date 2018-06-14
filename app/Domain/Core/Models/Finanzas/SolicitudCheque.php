<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 14/06/2018
 * Time: 01:11 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\Scopes\SolicitudChequeScope;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class SolicitudCheque extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Solicitud de Cheque
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SolicitudChequeScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::PAGO_A_CUENTA;
            $model->opciones = 327681;
            $model->id_moneda = 1;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->id_obra = Context::getId();
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
            $model->saldo = $model->monto;
        });
    }
}