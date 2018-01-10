<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\RoleRepository;
use Ghi\Domain\Core\Models\Seguridad\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentRoleRepository implements RoleRepository
{
    /**
     * @var Role
     */
    protected $model;

    /**
     * EloquentRoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de Rol
     * @return Collection | Role
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Crea un nuevo registro de Rol
     * @param array $data
     * @return Role
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('seguridad')->beginTransacton();

            //TODO : Registrar un nuevo Rol con $data

            DB::connection('seguridad')->commit();

            return ;
        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
            throw $e;
        }
    }

    /**
     * Actualiza un Registro de Rol
     * @param array $data
     * @param $id_role
     * @return Role
     * @throws \Exception
     */
    public function update(array $data, $id_role)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina un Registro de Rol
     * @param $id_role
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_role)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Regresa registros de Roles Paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model->with('perms')->orderBy('display_name', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }
}