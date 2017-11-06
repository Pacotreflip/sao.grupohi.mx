<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 04:39 AM
 */

namespace Ghi\Domain\Core\Contracts;



interface ContratoProyectadoRepository
{
    /**
     * Crea un nuevo registro de Contrato Proyectado
     * @return Sucursal
     */
    public function create(array $data);

    public function edit();

    public function addItem();

    public function removeItem();
}