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

class Estimacion extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Subcontrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EstimacionScope());
        static::addGlobalScope(new ObraScope());
    }
}