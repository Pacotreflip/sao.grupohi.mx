<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 07/11/2017
 * Time: 10:55 AM
 */

namespace Ghi\Domain\Core\Contracts;

use Ghi\Domain\Core\Models\Contrato;

interface ContratoRepository
{
    /**
     * Actualiza un registro de Contrato
     * @return Contrato
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Busca un Contrato por su ID
     * @param $id
     * @return Contrato
     */
    public function find($id);
}