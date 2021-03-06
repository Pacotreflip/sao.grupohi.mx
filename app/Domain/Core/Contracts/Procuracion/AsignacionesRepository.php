<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:29
 */

namespace Ghi\Domain\Core\Contracts\Procuracion;

use Ghi\Domain\Core\Models\Procuracion\Asignaciones;

/**
 * Interface AsignacionesRepository
 * @package Ghi\Domain\Core\Contracts\Procuracion
 */
interface AsignacionesRepository
{
    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return Asignaciones
     * @throws \Exception
     */
    public function create($data);

    /**
     * Obtiene todos los registros de la Asignaciones
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Asignaciones
     */
    public function all();

    /**
     * Aplica un SoftDelete a la Asignaciones seleccionado
     * @param $id Identificador del registro de Tipo de Asignaciones que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);

    /**
     * Regresa las Asignaciones Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param array $relations
     * @return mixed
     */
    public function with(array $relations);

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);
    /**
     *  Si existe un usuarios asignado a las transaccion
     * @param array $where
     * @return mixed
     */
    public function exists(array $where);

    /**
     * @return mixed
     */
    public function refresh();
}