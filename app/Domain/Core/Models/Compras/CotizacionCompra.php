<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/03/2018
 * Time: 05:11 PM
 */

namespace Ghi\Domain\Core\Models\Compras;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCCotizaciones;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\CotizacionCompraScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Sucursal;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

/**
 * Class CotizacionCompra
 * @package Ghi\Domain\Core\Models\Compras
 */
class CotizacionCompra extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Cotización de Compra
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CotizacionCompraScope());
        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cotizaciones() {
        return $this->hasMany(Cotizacion::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rqctocCotizacion() {
        return $this->hasOne(RQCTOCCotizaciones::class, 'idtransaccion_sao', 'id_transaccion')
            ->where(['idobra_sao'=>Context::getId(),'base_sao'=>Context::getDatabaseName(),]);
    }
}