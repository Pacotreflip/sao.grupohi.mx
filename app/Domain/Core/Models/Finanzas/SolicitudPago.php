<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 14/06/2018
 * Time: 01:11 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Scopes\SolicitudPagoScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class SolicitudPago extends Transaccion
{

    protected $appends = ['tipo_transaccion_string', 'tipo_cambio', 'id_rubro', 'seleccionada'];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Solicitud de Pago
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SolicitudPagoScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::SOLICITUD_PAGO;
            $model->id_moneda = Moneda::PESOS;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->id_obra = Context::getId();
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
            $model->fecha = Carbon::now()->toDateString();
            $model->saldo = $model->monto;
        });
    }

    public function antecedente() {
        return $this->belongsTo(Transaccion::class, 'id_antecedente');
    }

    public function rubros() {
        return $this->belongsToMany(Rubro::class, 'Finanzas.transacciones_rubros', 'id_transaccion', 'id_rubro');
    }

    public function getIdRubroAttribute() {
        return isset($this->rubros[0]) ? $this->rubros[0]->id : null;
    }

    public function getSeleccionadaAttribute() {
       /* SolicitudRecursos::where()->whereHas('partidas', function ($q) {
           $q->where('id_transaccion', '=', $this->id_transaccion);
        })->first();*/
        //TODO: regresa TRUE si hay una SolicitudRecursosPartida para la SolicitudRecursos semana actual y el año actual
    }
}