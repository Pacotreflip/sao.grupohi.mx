<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:13 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;

interface SolicitudCambioPartidaRepository
{
    /**
     * Obtiene todos los registros de SolicitudCambioPartida
     *
     * @return SolicitudCambioPartida
     */
    public function all();

    /**
     * Guarda un registro de SolicitudCambioPartida
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambioPartida
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de SolicitudCambioPartida
     * @param $id
     * @return SolicitudCambioPartida
     */
    public function find($id);
}