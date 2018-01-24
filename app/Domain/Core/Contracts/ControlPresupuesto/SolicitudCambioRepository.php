<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:00 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;
use \Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;

interface SolicitudCambioRepository
{
    /**
     * Obtiene todos los registros del estatus
     *
     * @return SolicitudCambio
     */
    public function all();

    /**
     * Regresa todas las solicitudes de cambio
     * @return Collection | SolicitudCambio
     */

    public function paginate(array $data);

    /**
     * Guarda un registro de SolicitudCambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de SolicitudCambio
     * @param $id
     * @return SolicitudCambio
     */
    public function find($id);
}