<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:18 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;

interface PartidasInsumosAgrupadosRepository
{
    /**
     * Obtiene todos los registros de SolicitudCambioRechazada
     *
     * @return SolicitudCambioRechazada
     */
    public function all();


    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);
    /**
     * Crea relaciones eloquent
     * @param array|string $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations);
}