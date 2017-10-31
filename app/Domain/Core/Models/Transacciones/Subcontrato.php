<?php

namespace Ghi\Domain\Core\Models\Transacciones;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:25 PM
 */

use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\SubcontratoScope;

class Subcontrato extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Subcontrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SubcontratoScope());
        static::addGlobalScope(new ObraScope());
    }

    public function __toString()
    {
        return $this->referencia;
    }

    public function empresa() {
        return $this->hasOne(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function getMontoSubcontratoAttribute() {
        return $this->monto - $this->impuesto;
    }

    public function estimaciones() {
        return $this->hasMany(Estimacion::class, 'id_antecedente', 'id_transaccion');
    }
}