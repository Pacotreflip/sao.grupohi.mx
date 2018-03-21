<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\ConfigNivelesPresupuestoRepository;
use Ghi\Domain\Core\Models\Seguridad\ConfigNivelesPresupuesto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentConfigNivelesPresupuestoRepository implements ConfigNivelesPresupuestoRepository
{
    /**
     * @var ConfigNivelesPresupuesto
     */
    protected $model;

    /**
     * EloquentConfigNivelesPresupuestoRepository constructor.
     * @param ConfigNivelesPresupuesto $model
     */
    public function __construct(ConfigNivelesPresupuesto $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de configuración de los niveles del presupuesto
     * @return Collection | ConfigNivelesPresupuesto
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Crea un nuevo registro de la configuración de niveles del presupuesto
     * @param array $data
     * @return ConfigNivelesPresupuesto
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
     * Actualiza un Registro de la configuración de nivel del presupuesto
     * @param array $data
     * @param $id
     * @return ConfigNivelesPresupuesto
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        $configNivel = $this->model->find($id);

        $configNivel->update($data);

        return $this->model->find($id);
    }

    /**
     * Elimina un Registro de la configuración de nivel del presupuesto
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id_role)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Regresa registros de la configuración de nivel del presupuesto Paginados
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
     * Regresa el Registro de la configuración de nivel del presupuesto Buscado
     * @param $id
     * @return ConfigNivelesPresupuesto
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}