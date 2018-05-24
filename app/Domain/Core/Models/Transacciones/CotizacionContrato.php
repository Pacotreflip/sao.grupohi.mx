<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Models\Transacciones;


use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Presupuesto;
use Ghi\Domain\Core\Models\Scopes\CotizacionContratoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Sucursal;

class CotizacionContrato extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Cotización de Contrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CotizacionContratoScope());
        static::addGlobalScope(new ObraScope());
    }

    public function presupuestos() {
        return $this->hasMany(Presupuesto::class, 'id_transaccion', 'id_transaccion');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function getCandidataAttribute()
    {
        $res = false;
        foreach ($this->presupuestos as $presupuesto) {
            if($presupuesto->no_cotizado == 0) {
                if($presupuesto->contrato->cantidad_pendiente > 0) {
                    $res = true;
                }
            }
        }

        return $res;
    }
}