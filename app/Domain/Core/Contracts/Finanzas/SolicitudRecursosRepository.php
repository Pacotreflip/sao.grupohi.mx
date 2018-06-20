<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:46 PM
 */

namespace Ghi\Domain\Core\Contracts\Finanzas;


use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;

interface SolicitudRecursosRepository
{
    /**
     * Crea un registro de Solicitud de Recursos con sus Partidas
     *
     * @param array $data
     * @return SolicitudRecursos|mixed
     * @throws \Exception
     */
    public function create($data);
}