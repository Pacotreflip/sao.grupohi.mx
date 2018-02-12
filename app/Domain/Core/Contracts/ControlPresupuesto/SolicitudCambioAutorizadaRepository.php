<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:17 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;

interface SolicitudCambioAutorizadaRepository
{
    /**
     * Obtiene todos los registros de SolicitudCambioAutorizada
     *
     * @return SolicitudCambioAutorizada
     */
    public function all();

    /**
     * Guarda un registro de SolicitudCambioAutorizada
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambioAutorizada
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de SolicitudCambioAutorizada
     * @param $id
     * @return SolicitudCambioAutorizada
     */
    public function find($id);
}