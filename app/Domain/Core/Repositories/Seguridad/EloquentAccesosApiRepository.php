<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\AccesosApiRepository;
use Ghi\Domain\Core\Models\Seguridad\ConfigNivelesPresupuesto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentAccesosApiRepository
 * @package Ghi\Domain\Core\Repositories\Seguridad
 */
class EloquentAccesosApiRepository implements AccesosApiRepository
{
    /**
     * @var AccesosApiRepository
     */
    protected $model;

    /**
     * EloquentAccesosApiRepository constructor.
     * @param AccesosApiRepository $model
     */
    public function __construct(AccesosApiRepository $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de configuración de los accesos a la api
     * @return Collection | AccesosApiRepository
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Crea un nuevo registro de la configuración de los accesos a la api
     * @param array $data
     * @return AccesosApiRepository
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('seguridad')->beginTransaction();

            $configNivel = $this->model->create($data);

            DB::connection('seguridad')->commit();

            return $configNivel;
        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
            throw $e;
        }
    }

    /**
     * Actualiza un Registro de la configuración de los accesos a la api
     * @param array $data
     * @param $id
     * @return AccesosApiRepository
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        $configNivel = $this->model->find($id);

        $configNivel->update($data);

        return $this->model->find($id);
    }

    /**
     * Elimina un Registro de la configuración de los accesos a la api
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_role)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Regresa registros de la configuración de los accesos a la api
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model;

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
     * Regresa el Registro de la configuración de los accesos a la api
     * @param $id
     * @return AccesosApiRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}