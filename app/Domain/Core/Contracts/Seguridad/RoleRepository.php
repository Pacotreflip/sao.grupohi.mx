<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 05/01/2018
 * Time: 06:41 PM
 */

namespace Ghi\Domain\Core\Contracts\Seguridad;


use Ghi\Domain\Core\Models\Seguridad\Role;
use Illuminate\Support\Collection;

interface RoleRepository
{
    /**
     * Obtiene todos los registros de Rol
     * @return Collection | Role
     */
    public function all();

    /**
     * Crea un nuevo registro de Rol
     * @param array $data
     * @return Role
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Registro de Rol
     * @param array $data
     * @param $id_role
     * @return Role
     * @throws \Exception
     */
    public function update(array $data, $id_role);

    /**
     * Elimina un Registro de Rol
     * @param $id_role
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_role);

    /**
     * Regresa registros de Roles Paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);
}