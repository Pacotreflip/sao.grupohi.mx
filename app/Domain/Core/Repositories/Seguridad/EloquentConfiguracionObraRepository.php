<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\ConfiguracionObraRepository;
use Ghi\Domain\Core\Models\Seguridad\ConfiguracionObra;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentConfiguracionObraRepository implements ConfiguracionObraRepository
{
    /**
     * @var ConfiguracionObra
     */
    protected $model;

    /**
     * EloquentObraRepository constructor.
     * @param ConfiguracionObra $model
     */
    public function __construct(ConfiguracionObra $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de configuración de la obra
     * @return Collection | ConfiguracionObra
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Crea un nuevo registro de la configuración de la obra
     * @param array $data
     * @return ConfiguracionObra
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
     * Actualiza un Registro de la configuración de la obra
     * @param array $data
     * @param $id
     * @return ConfiguracionObra
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        $configNivel = $this->model->find($id);

        $configNivel->update($data);

        return $this->model->find($id);
    }

    /**
     * Elimina un Registro de la configuración de la obra
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la plantilla que se desea eliminar', 404));
            }
            $item->destroy($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
    }

    /**
     * Regresa registros de la configuración de nivel de la obra
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
     * Regresa el Registro de la configuración de nivel de la obra Buscado
     * @param $id
     * @return ConfiguracionObra
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}