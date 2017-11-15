<?php

namespace Ghi\Domain\Core\Models\Transacciones;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:25 PM
 */

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\EstimacionScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Descuento;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Liberacion;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Retencion;

class Estimacion extends Transaccion
{

    protected $dates = ['fecha', 'cumplimiento', 'vencimiento'];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Estimación
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EstimacionScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function($model) {
            $model->opciones = 0;
            $model->id_obra = Context::getId();
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->tipo_transaccion = Tipo::ESTIMACION;
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
        });
    }

    public function subcontrato()
    {
        return $this->hasOne(Subcontrato::class, 'id_transaccion', 'id_antecedente');
    }

    public function getSumaImportesAttribute()
    {
        return $this->items()->sum('importe');

    }

    public function getMontoAnticipoAplicadoAttribute()
    {
        return $this->suma_importes * ($this->anticipo / 100);
    }

    public function getImportesAttribute()
    {
        return $this->monto - $this->impuesto;
    }

    public function subcontratoEstimacion()
    {
        return $this->hasOne(\Ghi\Domain\Core\Models\SubcontratosEstimaciones\Estimacion::class, 'IDEstimacion', 'id_transaccion');
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class, 'id_transaccion', 'id_transaccion');
    }

    public function retenciones()
    {
        return $this->hasMany(Retencion::class, 'id_transaccion', 'id_transaccion');
    }

    public function liberaciones()
    {
        return $this->hasMany(Liberacion::class, 'id_transaccion', 'id_transaccion');
    }

    public function getMontoAPagarAttribute()
    {
        return (
            $this->monto

            - ($this->subcontratoEstimacion ? $this->subcontratoEstimacion->ImporteFondoGarantia : 0)
            - $this->descuentos->sum('importe')
            - $this->retenciones->sum('importe')
            - $this->IVARetenido
            + $this->liberaciones->sum('importe')
            + ($this->subcontratoEstimacion ? $this->subcontratoEstimacion->ImporteAnticipoLiberar : 0)
        );
    }

    public function getSumMontoRetencionAttribute() {
        return $this->suma_importes * ( $this->retencion / 100 );
    }

    public function getRetenidoAnteriorAttribute() {
        $estimaciones_anteriores = $this->subcontrato->estimaciones()->where('id_transaccion', '<', $this->id_transaccion)->get();

        $sumatoria = 0;
        foreach ($estimaciones_anteriores as $estimacion) {
            $sumatoria += $estimacion->SumMontoRetencion;
        }
        return $sumatoria;
    }

    public function getRetenidoOrigenAttribute() {
        $estimaciones_anteriores = $this->subcontrato->estimaciones()->where('id_transaccion', '<', $this->id_transaccion)->get();

        $sumatoria = 0;
        foreach ($estimaciones_anteriores as $estimacion) {
            $sumatoria += $estimacion->SumMontoRetencion;
        }
        return $sumatoria + $this->SumMontoRetencion;
    }

    public function getAmortizacionPendienteAttribute() {
        $estimaciones_anteriores = $this->subcontrato->estimaciones()->where('id_transaccion', '<', $this->id_transaccion)->get();
            return $this->subcontrato->anticipo_monto - $estimaciones_anteriores->sum('monto_anticipo_aplicado') - $this->monto_anticipo_aplicado;
    }

    public function getAmortizacionPendienteAnteriorAttribute() {
        $estimacion_anterior = $this->subcontrato->estimaciones()->where('id_transaccion', '<', $this->id_transaccion)->orderBy('id_transaccion', 'DESC')->first();

        if($estimacion_anterior) {
            return $estimacion_anterior->amortizacion_pendiente;
        } else {
            return 0;
        }
    }
}