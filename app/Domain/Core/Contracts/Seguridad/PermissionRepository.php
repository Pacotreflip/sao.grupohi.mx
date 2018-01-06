<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 05/01/2018
 * Time: 06:47 PM
 */

namespace Ghi\Domain\Core\Contracts\Seguridad;

use Ghi\Domain\Core\Models\Seguridad\Permission;
use Illuminate\Support\Collection;

interface PermissionRepository
{
    /**
     * Obtiene todos los registros de Permiso
     * @return Collection | Permission
     */
    public function all();

    /**
     * Crea un nuevo registro de Permiso
     * @param array $data
     * @return Permission
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Registro de Permiso
     * @param array $data
     * @param $id_permission
     * @return Permission
     * @throws \Exception
     */
    public function update(array $data, $id_permission);

    /**
     * Elimina un Registro de Permiso
     * @param $id_permission
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_permission);
}