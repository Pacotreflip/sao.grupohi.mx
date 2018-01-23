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
            DB::connection('seguridad')->beginTransaction();

            $permisos = isset($data['permissions']) ? $data['permissions'] : [];
            $role = $this->model->create($data);
            $role->savePermissions($permisos);

            DB::connection('seguridad')->commit();

            return $role;
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
        $permisos = isset($data['permissions']) ? $data['permissions'] : [];

        $role = $this->model->find($id_role);
        $role->update($data);
        $role->savePermissions($permisos);

        return $this->model->with('perms')->find($id_role);
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
        $query = $this->model->with(['perms' => function ($q){
            return $q->orderBy('name', 'asc');
        }]);

        $query->where(function ($q) use ($data){
            return $q
                ->where('description', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('name', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('display_name', 'like', '%'.$data['search']['value'].'%');
        });

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }


    /**
     * Regresa el Registro del Rol Buscado
     * @param $id
     * @return Role
     */
    public function find($id)
    {
        return $this->model->with(['perms' => function ($q){
            return $q->orderBy('name', 'asc');
        }])->find($id);
    }
}