<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 04:39 AM
 */

namespace Ghi\Domain\Core\Contracts;



use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;

interface ContratoProyectadoRepository
{

    /**
     * Crea un nuevo registro de Contrato Proyectado
     * @param array $data
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Contrato Proyectado
     * @param array $data
     * @param $id
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function update(array $data, $id);
}