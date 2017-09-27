<?php

namespace Ghi\Domain\Core\Models\Transacciones;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:25 PM
 */

use Ghi\Domain\Core\Models\Scopes\EstimacionScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Descuento;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Liberacion;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Retencion;

class Estimacion extends Transaccion
{

    protected $dates = ['fecha', 'cumplimiento', 'vencimiento'];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Subcontrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EstimacionScope());
        static::addGlobalScope(new ObraScope());
    }

    public function subcontrato()
    {
        return $this->hasOne(Subcontrato::class, 'id_transaccion', 'id_antecedente');
    }

    public function getSumaImportesAttribute()
    {
        $suma = 0;
        foreach ($this->items as $item) {
            $suma += $item->importe;
        }
        return $suma;
    }

    public function getMontoAnticipoAplicadoAttribute()
    {
        return $this->suma_importes * ($this->subcontrato->anticipo / 100);
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
            - $this->subcontratoEstimacion->ImporteFondoGarantia
            - $this->descuentos->sum('importe')
            - $this->retenciones->sum('importe')
            - $this->IVARetenido
            + $this->liberaciones->sum('importe')
            + $this->subcontratoEstimacion->ImporteAnticipoLiberar
        );
    }

    public function getSumMontoAnticipoAplicadoAttribute()
    {
        return  ($this->suma_importes -($this->importes) - ($this->suma_importes * ($this->retencion / 100)));
    }

    public function getSumMontoRetencionAttribute() {
        return $this->suma_importes * ( $this->retencion / 100 );
    }

    public function getRetenidoAnteriorAttribute() {
        $sumatoria = 0;
        foreach ($this->subcontrato->estimaciones as $estimacion) {
            $sumatoria += $estimacion->SumMontoRetencion;
        }
        return $sumatoria - $this->SumMontoRetencion;
    }

    public function getRetenidoOrigenAttribute() {
        $sumatoria = 0;
        foreach ($this->subcontrato->estimaciones as $estimacion) {
            $sumatoria += $estimacion->SumMontoRetencion;
        }
        return $sumatoria;
    }
}