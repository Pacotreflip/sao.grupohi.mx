<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 05/11/2017
 * Time: 23:59
 */

namespace Ghi\Domain\Core\Models\Transacciones;


use Ghi\Domain\Core\Models\Scopes\ContratoProyectadoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;

class ContratoProyectado extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Contrato Proyectado
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ContratoProyectadoScope());
        static::addGlobalScope(new ObraScope());
    }
}