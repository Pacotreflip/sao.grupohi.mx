<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:29
 */

namespace Ghi\Domain\Core\Contracts\Procuracion;

use Ghi\Domain\Core\Models\Procuracion\Asingacion;

/**
 * Interface AsignacionRepository
 * @package Ghi\Domain\Core\Contracts\Procuracion
 */
interface AsignacionRepository
{
    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return Asingacion
     * @throws \Exception
     */
    public function create($data);

    /**
     * Obtiene todos los registros de la Asignacion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Asingacion
     */
    public function all();

    /**
     * Aplica un SoftDelete a la Asingacion seleccionado
     * @param $id Identificador del registro de Tipo de Asinaciones que se va a eliminar
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
}