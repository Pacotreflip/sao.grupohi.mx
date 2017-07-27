<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 25/07/2017
 * Time: 06:45 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface TipoCuentaMaterialRepository
{
    /**
     * Obtiene todos los Tipos de Cuentas Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TipoCuentaMaterial
     */
    public function all();
}