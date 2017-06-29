<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Contracts;



interface EmpresaRepository
{
    /**
     * @param $with
     * @return Ghi\Domain\Core\Models\Contabilidad\collection|CuentaEmpresa
     */
    public function all($with);

    /**
     * @param $id
     * @return Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa
     */
    public function find($id, $with);
}