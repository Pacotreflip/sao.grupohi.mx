<?php

namespace Ghi\Domain\Core\Models\Transacciones;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:25 PM
 */

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
}