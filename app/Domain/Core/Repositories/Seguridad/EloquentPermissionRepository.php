<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\PermissionRepository;
use Ghi\Domain\Core\Models\Seguridad\Permission;
use Illuminate\Support\Collection;

class EloquentPermissionRepository implements PermissionRepository
{
    /**
     * @var Permission
     */
    protected $model;

    /**
     * EloquentPermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Permiso
     * @return Collection | Permission
     */
    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    /**
     * Crea un nuevo registro de Permiso
     * @param array $data
     * @return Permission
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('seguridad')->beginTransacton();

            //TODO : Registrar un nuevo Permiso con $data

            DB::connection('seguridad')->commit();

            return ;
        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
            throw $e;
        }
    }

    /**
     * Actualiza un Registro de Permiso
     * @param array $data
     * @param $id_permission
     * @return Permission
     * @throws \Exception
     */
    public function update(array $data, $id_permission)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina un Registro de Permiso
     * @param $id_permission
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_permission)
    {
        // TODO: Implement delete() method.
    }
}