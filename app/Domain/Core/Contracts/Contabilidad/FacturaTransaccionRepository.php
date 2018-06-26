<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 04:34 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


use Ghi\Domain\Core\Models\Contabilidad\FacturaTransaccion;

interface FacturaTransaccionRepository
{
    /**
     * Obtiene todas las transacciones tipo 65
     *
     * @return \Illuminate\Database\Eloquent\Collection|FacturaTransaccion
     */
    public function all();

    /**
     * @param $conditions
     * @return $this
     */
    public function where($conditions);

    public function with($with);

}