<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/06/2018
 * Time: 01:46 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\Scopes\ContrareciboScope;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class Contrarecibo extends Transaccion
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ContrareciboScope());
    }
}