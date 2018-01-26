<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:18 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;

interface SolicitudCambioRechazadaRepository
{
    /**
     * Obtiene todos los registros de SolicitudCambioRechazada
     *
     * @return SolicitudCambioRechazada
     */
    public function all();

    /**
     * Guarda un registro de SolicitudCambioRechazada
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambioRechazada
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de SolicitudCambioRechazada
     * @param $id
     * @return SolicitudCambioRechazada
     */
    public function find($id);
}